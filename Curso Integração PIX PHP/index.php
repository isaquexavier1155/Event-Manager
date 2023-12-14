<?php

require __DIR__.'/vendor/autoload.php';

use \App\Pix\Payload;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

//INSTANCIA PRINCIPAL DO PAYLOAD PIX
                          //CONTA RECEBEDOR
$obPayload = (new Payload)->setPixKey('isaque.ixs@gmail.com')
                          ->setDescription('Pagamento do pedido 123456')
                          ->setMerchantName('Willian Costa')
                          ->setMerchantCity('IGREJINHA')
                          ->setTxtid('WDEV1234')
                          ->setAmount(3.00);
                          
//CODIGO DE PAGAMENTO PIX
$payloadQrCode = $obPayload->getPayLoad();

//INSTANCIA QR CODE
$obQrCode = new QrCode($payloadQrCode);
//IMAGEM QR CODE da classe Png da Output
$image = (new Output\Png)->output($obQrCode, 200);

?>

<h1>QR CODE PIX</h1>
<br>
<img src="data:image/png;base64, <?=base64_encode($image)?>">
<br><br>
Código PIX:<br>
<strong><?=$payloadQrCode?></strong>