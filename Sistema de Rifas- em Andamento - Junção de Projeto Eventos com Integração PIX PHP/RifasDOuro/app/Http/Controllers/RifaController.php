<?php

namespace App\Http\Controllers;

use App\Models\Rifa;
use Illuminate\Http\Request;

use App\Models\User;
use App\Pix\Payload;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;
use App\Pix\Api;

use Illuminate\Pagination\LengthAwarePaginator;

class RifaController extends Controller
{

    private $valorUnico; // Propriedade para armazenar o valor único

    private function gerarValorUnico($length)
    {
        // Lógica para gerar um valor único com o comprimento desejado (exemplo)
        return substr(md5(uniqid(mt_rand(), true)), 0, $length);

        
    }

    public function index(){
        //dd($events); // Verifique os eventos aqui
        return view('rifas.home');

    }

    public function home(){
        return view('rifas.home');
    }

    public function create()
    {
         // Obtém o usuário autenticado
        $user = auth()->user();

        // Obtém o valor do atributo 'name' do usuário
        $userName = $user ? $user->name : null;

        $obPayload = (new Payload)
        ->setPixKey('isaque.ixs@gmail.com')
        ->setDescription('Pagamento do pedido 123456')
        ->setMerchantName('Willian Costa')
        ->setMerchantCity('IGREJINHA')
        ->setTxtid('WDEV1234')
        ->setAmount(3.00);

        $payloadQrCode = $obPayload->getPayLoad();

        $obQrCode = new QrCode($payloadQrCode);
        $image = (new Output\Png)->output($obQrCode, 200);

        return view('rifas.create_rifa', [
            'image' => base64_encode($image),
            'payloadQrCode' => $payloadQrCode,
            'userName' => $userName,
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'imagem' => 'image|max:4096', // Limite de 4 MB (ajuste conforme necessário)
            // Ajustar tambem arquivo php.ini do local c - pesquisar upload_max e ajustar, esta em 4MB
           //ajustar arquivo validation.php para ajustar mensagens para portugues
            'nome_campanha' => 'required|string|max:255',
            'descricao' => 'required|string|max:2000',
            'quantidade_bilhetes' => 'required|integer|min:1',      
        ]);

        $rifa = new Rifa;
        $rifa->nome_campanha = $request->nome_campanha;
        $rifa->quantidade_bilhetes = $request->quantidade_bilhetes;
        $valorBilhetes = str_replace(['R$', ',', ' '], ['', '.', ''], $request->valor_bilhetes);
       // Remover caracteres não numéricos, incluindo espaços em branco, do início da string
        $valorLimpo = preg_replace('/[^\d.]/', '', $valorBilhetes);
        $valorFloat = floatval($valorLimpo);

        $rifa->valor_bilhetes = $valorFloat ;
        $rifa->local_sorteio = $request->local_sorteio;
        $telefone = preg_replace('/[^0-9]/', '', $request->telefone);
        $rifa->telefone = $telefone;
        $rifa->status_cobranca_taxa_publicacao = "ATIVA";
        $rifa->descricao = $request->descricao;
        //dd($request->imagem);
        //$rifa->imagem = $request->imagem;
                //Image Upload

                if($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
                    $requestImage = $request->imagem;
                    $extension = $requestImage->extension();
                    $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
                    $requestImage->move(public_path('img/rifas'), $imageName);
                    $rifa->imagem = $imageName;
                }
        
        // Obtenha o usuário autenticado (se estiver usando autenticação)
        $user = auth()->user();

        // Obtém o valor do atributo 'name' do usuário
        $userName = $user ? $user->name : null;
    
        // Verifique se o usuário está autenticado antes de acessar a propriedade id
        if ($user) {
            $rifa->user_id = $user->id;
        } else {
            // Lógica para lidar com o cenário em que o usuário não está autenticado
            return redirect('/login')->with('msg', 'Você precisa estar logado para criar uma rifa.');
        }

       //dd($request->all()); // Verifique os dados recebidos
        $rifa->save();

        // Obtém o ID da rifa recém-criada
        $rifaId = $rifa->id;

        // Após obter o ID da Rifa
        session(['rifaId' => $rifaId]);

        // Obtém os atributos quantidade_bilhetes e valor_bilhetes
        $quantidadeBilhetes = intval($rifa->quantidade_bilhetes);
        $valorBilhetesFloat = (float) $rifa->valor_bilhetes;
        $arrecadacaoEstimada = $quantidadeBilhetes * $valorBilhetesFloat;
        $taxaPublicacao = 0.06 * $arrecadacaoEstimada;
        // Formatando a string de acordo com o padrão desejado
        $taxaPublicacaoString = sprintf("%.2f", $taxaPublicacao);
     
        // Substitui acentos e caracteres especiais
        $cleanUserName = str_replace(['á', 'à', 'ã', 'â', 'é', 'è', 'ê', 'í', 'ì', 'î', 'ó', 'ò', 'õ', 'ô', 'ú', 'ù', 'û', 'ç'], 
                                    ['a', 'a', 'a', 'a', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'c'], 
                                    $userName);
        // Remove outros caracteres especiais
        $cleanUserName = preg_replace('/[^a-zA-Z0-9\s]/', '', $cleanUserName);

        ////////////////////////////////Inicio QrCode Dinâmico
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
        'original' => $taxaPublicacaoString
        ],
        'chave' => $pixKey,
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
        $rifa->txId = $txId;
        $rifa->taxa_publicacao = $taxaPublicacao;
       
        $rifa->save();

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

        $statusCobranca = $response['status'];

        // Formatando a taxa de publicação para exibir milhares com separador de milhar e duas casas decimais
        $taxaPublicacaoStringForm = number_format($taxaPublicacaoString, 2, ',', '.');

        return view('pix.payment_fee_publication', [
            'image' => base64_encode($image),
            'payloadQrCode' => $payloadQrCode,
            'statusCobranca' => $statusCobranca,
            'taxaPublicacaoString' => $taxaPublicacaoStringForm,
            'arrecadacaoEstimada' => $arrecadacaoEstimada,
        ]);

    }

    public function consultQrCode()
    {
        // Verifica se o usuário está autenticado
        if (auth()->check()) {

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

            // Recupera o valor único da sessão
            $valorUnico = session('valorUnico');

            //dd($valorUnico);
        
            // Utiliza o mesmo valor único gerado na função store
            $response = $obApiPix->consultCob($valorUnico);

            // LOG DA RESPOSTA
            \Illuminate\Support\Facades\Log::info('Resposta da Consulta PIX: ' . json_encode($response));

            if (!isset($response['location'])) {
                return response()->json(['error' => 'Problemas ao consultar Pix dinâmico', 'response' => $response]);
            }

            // DEBUG DOS DADOS DO RETORNO
            $debugResponse = $response;
            $statusCobranca = $response['status'];

            // VERIFICA SE O STATUS É "CONCLUIDA"
            if ($statusCobranca === 'CONCLUIDA') {

                $rifaId = session('rifaId');

                // Procura um registro existente com base no valor único
                $rifa = Rifa::where('id', $rifaId)->first();
        
                if ($rifa) {
                    // Atualiza o campo 'status_cobranca_taxa_publicacao'
                    $rifa->status_cobranca_taxa_publicacao = 'CONCLUIDA';
                    $rifa->save();
                } else {
                    // Se não encontrar, cria um novo objeto
                    $rifa = new Rifa;
                    // ... (restante do código para atribuir valores ao novo objeto)
                    $rifa->save();
                }
        
                // REDIRECIONA PARA A ROTA /home
                return response()->json(['status' => $statusCobranca, 'message' => 'Redirecionando para /home']);
            }
        
            // Se o status não for "]", continua com a exibição dos dados
            return response()->json(['status' => $statusCobranca, 'debug_response' => $debugResponse]);
        }
    }

    public function dashboard_minhas_rifas() {
        $user = auth()->user();
        
        // Obter apenas as rifas com status_cobranca_taxa_publicacao igual a "ATIVA"
        $rifas = $user->rifas()->where('status_cobranca_taxa_publicacao', 'ATIVA')->get();
    
        $rifasAsParticipant = $user->rifasAsParticipant;
        
        return view('rifas.dashboard-minhas-rifas', ['rifas' => $rifas, 'rifasAsParticipant' => $rifasAsParticipant]);
    }

    public function dashboard_minhas_configuracoes() {
        if (auth()->check()) {
            $user = auth()->user();
            // Obtém os usuários com o mesmo id do usuário autenticado
            $users = User::where('id', $user->id)->get();
    
            return view('rifas.dashboard-minhas-configuracoes', [
                'users' => $users             
            ]);
        } else {
            return redirect()->route('login');
        }
    }
    
    
    public function terms_of_use (){
        return view('rifas.terms_of_use');
    }

    public function policy() {
        return view('rifas.policy');
    }



///////////////////////////////////////////////////////////////////////////////////////
    //Metodos do lado do usuário comprador de bilhetes
    public function mostrarPaginaCompra($id)
    {
        // Obter a rifa pelo ID
        $rifa = Rifa::find($id);
    
        // Verificar se a rifa existe
        if (!$rifa) {
            abort(404); // Ou redirecionar para uma página de erro, se preferir
        }
    
        // Obtendo a quantidade total de bilhetes
        $quantidadeBilhetes = $rifa->quantidade_bilhetes;
    
        // Página padrão (pode ser ajustado conforme necessário)
        $pagina = request()->get('pagina', 1);
    
        // Calcular a quantidade de bilhetes por página
        $bilhetesPorPagina = 100;
    
        // Calcular o índice inicial para os bilhetes da página atual
        $indiceInicial = ($pagina - 1) * $bilhetesPorPagina + 1;
    
        // Calcular o índice final para os bilhetes da página atual
        $indiceFinal = min($pagina * $bilhetesPorPagina, $quantidadeBilhetes);
    
        // Criar um array de bilhetes para a página atual
        $bilhetes = range($indiceInicial, $indiceFinal);
    
        // Formatando a taxa de publicação para exibir milhares com separador de milhar e duas casas decimais
        $valorBilhetesForm2 = number_format($rifa->valor_bilhetes, 2, ',', '.');
        $valorBilhetesForm = str_replace(',', '.', $rifa->valor_bilhetes);
        // Criar uma instância de LengthAwarePaginator para a página atual
        $paginacao = new LengthAwarePaginator($bilhetes, $quantidadeBilhetes, $bilhetesPorPagina, $pagina);
    
        return view('rifas.comprar-bilhetes', [
            'rifa' => $rifa,
            'bilhetes' => $paginacao, // Agora, você passa o Paginator para a view
            'valorBilhetesForm' => $valorBilhetesForm,
            'valorBilhetesForm2' => $valorBilhetesForm2,
        ]);
    }


///////////////////////////////////////////////////////////////

    public function getMoreBilhetes(Request $request, $id, $pagina)
{
    $rifa = Rifa::find($id);

    if (!$rifa) {
        return response()->json(['error' => 'Rifa não encontrada'], 404);
    }

    $bilhetesPorPagina = 100;
    $indiceInicial = ($pagina - 1) * $bilhetesPorPagina + 1;
    $indiceFinal = min($pagina * $bilhetesPorPagina, $rifa->quantidade_bilhetes);

    $bilhetes = range($indiceInicial, $indiceFinal);

    return response()->json(['bilhetes' => $bilhetes]);
}
    
    
    

    
    
   // public function comprarBilhetes(Request $request)
  //  {
        // Lógica para processar a compra dos bilhetes
        // Valide os dados do formulário, registre a compra no banco de dados, etc.

    //    return redirect()->route('rifas.comprar.bilhetes')->with('success', 'Bilhetes comprados com sucesso!');
    //}

}