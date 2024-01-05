<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comprador;
use App\Models\Rifa;

use App\Models\User;
use App\Pix\Payload;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;
use App\Pix\Api;

use Illuminate\Pagination\LengthAwarePaginator;


class CompradorController extends Controller
{
    private $valorUnico; // Propriedade para armazenar o valor único

    private function gerarValorUnico($length)
    {
        // Lógica para gerar um valor único com o comprimento desejado (exemplo)
        return substr(md5(uniqid(mt_rand(), true)), 0, $length);

        
    }

    public function processarCompraBilhetes(Request $request)
    {
        $numerosSelecionados = $request->input('numerosSelecionados');
        $idCampanha = $request->query('rifaId');
        // Converte os números de volta para um array
        $numerosSelecionados = json_decode($numerosSelecionados);
               
        return view('compradores.processar-compra-bilhetes', [
            'numerosSelecionados' => $numerosSelecionados,
            'idCampanha' => $idCampanha
        ]);
    }
    
    public function store(Request $request)
    {
        // $request->validate([
        //     'nome_completo' => 'required|string',
        //     'email' => 'required|email',
        //     'telefone' => 'required|string',
        //     'repeticao_telefone' => 'required|string',
        //     'numerosSelecionados' => 'required|string', // Certifique-se de que o campo existe no formulário
        // ]);
    
        
        $comprador = Comprador::create([
            'nome_completo' => $request->input('nome_completo'),
            'email' => $request->input('email'),
            'telefone' => $request->input('telefone'),
            'repeticao_telefone' => $request->input('repeticao_telefone'),
            'numeros_escolhidos' => $request->input('numeros_escolhidos'),
            'id_campanha' => $request->input('id_campanha'),
            'status_cobranca_bilhetes' => 'ATIVA',
        ]);
              
        //return redirect()->route('compradores.processar-compra-bilhetes')->with('success', 'Compra realizada com sucesso!');
    
        /////////////////////////Inicio QrCode Dinâmico
        require_once base_path('vendor/autoload.php');
        require_once base_path('config/pix.php');
        $apiPixUrl = config('pix.api_url');
        $apiPixClientId = config('pix.api_client_id');
        $apiPixClientSecret = config('pix.api_client_secret');
        $apiPixCertificate = config('pix.api_certificate');
        $obApiPix = new Api($apiPixUrl,
        $apiPixClientId ,
        $apiPixClientSecret,
        $apiPixCertificate);
        $pixKey = config('pix.key');


        // Obtenha o usuário autenticado (se estiver usando autenticação)
        $user = auth()->user();
        // Obtém o valor do atributo 'name' do usuário
        $userName = $user ? $user->name : null;
        $userId = $user ? $user->id : null;

        //dd($userName);

        $idd_campanha = $request->input('id_campanha');

//INICIO CÁLCULO VALOR A SER PAGO ATRAVÉS DO NUMERO DE BILHETES SELECIONADOS
        // Obtendo os números escolhidos com base no $idCampanha
        $numerosEscolhidosArray = Comprador::where('id', $comprador->id)
        ->pluck('numeros_escolhidos')
        ->toArray();
        // Unindo os números escolhidos em uma única string
        $numerosConcatenados = implode(',', $numerosEscolhidosArray);
        // Explodindo a string para obter um array de todos os números
        $todosNumeros = explode(',', $numerosConcatenados);
        // Removendo possíveis valores vazios
        $todosNumeros = array_filter($todosNumeros);
        $contagemNumeros = count($todosNumeros);
        // Obtendo o valor_bilhetes com base no $idCampanha
        $valorBilhetes = Rifa::where('id', $idd_campanha)
        ->value('valor_bilhetes');
        $valorSerPago = $valorBilhetes * $contagemNumeros;
        //dd($contagemNumeros,$valorBilhetes, $valorPagar);
        //FIM CÁLCULO VALOR A SER PAGO ATRAVÉS DO NUMERO DE BILHETES SELECIONADOS

       //$taxaPublicacao = 0.06;
        // Formatando a string de acordo com o padrão desejado
        $ValorSerPagoString = sprintf("%.2f", $valorSerPago);

        $usuario = User::find($userId);
        // Verifica se o usuário foi encontrado
        if ($usuario) {
        // Obtém a chave_pix do usuário
        $chavePix = $usuario->chave_pix;
        //dd($usuario->id,$chavePix);

        //dd($chavePix, $pixKey);
        

    } else {
        // Usuário não encontrado
        return 'Usuário não encontrado';
    }

        //CORPO DA REQUISIÇÃO
        $request = [
        'calendario' => [
        'expiracao' => 3600
        ],
        'devedor' => [
        'cpf' => '12345678909',
        'nome' => $userName
        ],
        'valor' => [
        'original' => $ValorSerPagoString
        ],
        'chave' => $chavePix,
        'solicitacaoPagador' => 'Pagamento do pedido 123'
        ];

        // Gera um valor único e dinâmico com pelo menos 26 caracteres
        $this->valorUnico = $this->gerarValorUnico(26);

        session(['valorUnico' => $this->valorUnico]);

        //dd($this->valorUnico);

        // Antes da chamada da API
        error_log('Antes da chamada da API: ' . json_encode($request));
        // Chamada da API Pix usando o valor único
        $response = $obApiPix->createCob($this->valorUnico, $request);

        // Depois da chamada da API
        error_log('Depois da chamada da API: ' . json_encode($response));

        if (!isset($response['location'])) {
        error_log('Erro ao gerar Pix dinâmico: ' . json_encode($response));
        echo 'Problemas ao gerar Pix dinâmico';

        //deixar esse para mostrar mensagem quando for cobrança duplicada
        echo '<pre>';
        print_r($response);
        echo '</pre>';
        exit;
        }

        // Salve o txId na sessão
        $txId = $response['txid'];
        session(['valorUnico' => $this->valorUnico, 'txId' => $txId]);
        // Salve o txId no banco de dados
        //$rifa->txId = $txId;
        //$rifa->taxa_publicacao = $taxaPublicacao;

        //$rifa->save();

        //$pixMerchantName = config('pix.merchant_name');
        $pixMerchantCity = config('pix.merchant_city');

        //INSTANCIA PRINCIPAL DO PAYLOAD PIX
        $obPayload = (new Payload)->setMerchantName($userName)
            ->setMerchantCity($pixMerchantCity)
            ->setAmount($response['valor']['original'])
            ->setTxtid('txid')
            ->setUrl($response['location'])
            ->setUniquePayment(true);

        //CÓDIGO DE PAGAMENTO PIX
        $payloadQrCode = $obPayload->getPayload();
        $obQrCode = new QrCode($payloadQrCode);
        $image = (new Output\Png)->output($obQrCode, 200);

        //$statusCobranca = $response['status'];

        // Formatando a taxa de publicação para exibir milhares com separador de milhar e duas casas decimais
        $ValorSerPagoStringForm = number_format($ValorSerPagoString, 2, ',', '.');

        return view('pix.payment_purchased_tickets', [
            'image' => base64_encode($image),
            'payloadQrCode' => $payloadQrCode,
            //'statusCobranca' => $statusCobranca,
            'valorSerPago' => $ValorSerPagoStringForm,
            //'arrecadacaoEstimada' => $arrecadacaoEstimada,
        ]);
           
    }
    
    public function obterNumerosEscolhidos(Request $request)
    {
        try {
            $idCampanha = $request->get('id_campanha', null);
    
            if ($idCampanha) {
                $numerosEscolhidos = Comprador::where('id_campanha', $idCampanha)
                    ->pluck('numeros_escolhidos')
                    ->toArray();
    
                return response()->json(['numerosEscolhidos' => $numerosEscolhidos]);
            }
    
            return response()->json(['numerosEscolhidos' => []]);
        } catch (\Exception $e) {
            // Registre a exceção no log
            \Log::error($e);
    
            // Retorne uma resposta de erro ao cliente
            return response()->json(['error' => 'Erro interno no servidor'], 500);
        }
    }
    
}
