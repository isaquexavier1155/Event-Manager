<?php

$email = 'vinícios@alura.com.br';

$posicaoDoArroba = strpos($email, '@');


$usuario = substr($email , 0, $posicaoDoArroba);

echo strtoupper($usuario) . PHP_EOL;
echo strtolower($usuario) . PHP_EOL;
echo mb_strlen($usuario) . PHP_EOL;
echo mb_strtoupper($usuario) . PHP_EOL;
echo mb_strtolower($usuario) . PHP_EOL;


echo substr($email , $posicaoDoArroba +1) .PHP_EOL;//pega palavras depois do arroba

?>