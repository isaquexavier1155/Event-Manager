<?php

// app/Http/Controllers/PixController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pix\Payload;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

class PixController extends Controller
{
    public function showQrCode()
    {
        // $obPayload = (new Payload)
        //     ->setPixKey('isaque.ixs@gmail.com')
        //     ->setDescription('Pagamento do pedido 123456')
        //     ->setMerchantName('Willian Costa')
        //     ->setMerchantCity('IGREJINHA')
        //     ->setTxtid('WDEV1234')
        //     ->setAmount(3.00);

        // $payloadQrCode = $obPayload->getPayLoad();

        // $obQrCode = new QrCode($payloadQrCode);
        // $image = (new Output\Png)->output($obQrCode, 200);

        // return view('pix.qr_code', [
        //     'image' => base64_encode($image),
        //     'payloadQrCode' => $payloadQrCode,
        //     'obPayload' => $obPayload, 
        // ]);
    }
}
