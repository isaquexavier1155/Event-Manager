<?php 

$nome = 'Vinicio Diass';
$edafamilia =  str_contains($nome, 'Dias');
var_dump($edafamilia);

if($edafamilia){
    echo ("$nome É da familia");
}else{
    echo "Não é da familia";
}

?>