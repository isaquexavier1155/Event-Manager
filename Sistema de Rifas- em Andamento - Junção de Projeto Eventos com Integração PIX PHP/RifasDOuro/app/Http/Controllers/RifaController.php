<?php

namespace App\Http\Controllers;

use App\Models\Rifa;
use Illuminate\Http\Request;

use App\Models\User;
use App\Pix\Payload;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

class RifaController extends Controller
{
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

        // Obtém os atributos quantidade_bilhetes e valor_bilhetes
        $quantidadeBilhetes = intval($rifa->quantidade_bilhetes);
        $valorBilhetesFloat = (float) $rifa->valor_bilhetes;
        $arrecadacaoEstimada = $quantidadeBilhetes * $valorBilhetesFloat;

        // Calcula a taxa de publicação
        $taxaPublicacao = 0.06 * $arrecadacaoEstimada;

        //dd($quantidadeBilhetes, $valorBilhetesFloat, $arrecadacaoEstimada, $taxaPublicacao);

        //////////////////////Passando objeto qrcode
        // Substitui acentos e caracteres especiais
        $cleanUserName = str_replace(['á', 'à', 'ã', 'â', 'é', 'è', 'ê', 'í', 'ì', 'î', 'ó', 'ò', 'õ', 'ô', 'ú', 'ù', 'û', 'ç'], 
                                    ['a', 'a', 'a', 'a', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'c'], 
                                    $userName);
        // Remove outros caracteres especiais
        $cleanUserName = preg_replace('/[^a-zA-Z0-9\s]/', '', $cleanUserName);

        //dd($cleanUserName);
        $obPayload = (new Payload)
        ->setPixKey('isaque.ixs@gmail.com')
        ->setDescription('Pagamento da rifa ID' . $rifaId)
        ->setMerchantName($cleanUserName)
        ->setMerchantCity('IGREJINHA')
        ->setTxtid('RIFADOUROID' . $rifaId)
        ->setAmount($taxaPublicacao);

        $payloadQrCode = $obPayload->getPayLoad();

        $obQrCode = new QrCode($payloadQrCode);
        $image = (new Output\Png)->output($obQrCode, 200);

        return view('pix.qr_code', [
            'image' => base64_encode($image),
            'payloadQrCode' => $payloadQrCode,
            'obPayload' => $obPayload, 
        ]);
        ///////////////////////////////
    
        //return redirect('/showQrCode');
        // return redirect('/home')->with('msg', 'Rifa criada com sucesso!');

    }

    public function dashboard() {

        $user = auth()->user();
        $rifas = $user->rifas;
        $rifasAsParticipant = $user->rifasAsParticipant;
        return view('rifas.dashboard', 
        ['rifas' => $rifas, 'rifasAsParticipant' => $rifasAsParticipant]
        );
    }
 
}