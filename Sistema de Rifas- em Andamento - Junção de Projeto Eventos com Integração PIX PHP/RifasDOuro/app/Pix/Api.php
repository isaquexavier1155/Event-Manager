<?php

namespace App\Pix;

use Illuminate\Support\Facades\Config;

class Api
{
    /**
     * URL base do PSP
     * @var string
     */
    private $baseUrl;

    /**
     * Client ID do oAuth2 do PSP
     * @var string
     */
    private $clientId;

    /**
     * Client secret do oAuht2 do PSP
     * @var string
     */
    private $clientSecret;

    /**
     * Caminho absoluto até o arquivo do certificado
     * @var string
     */
    private $certificate;

    /**
     * Define os dados iniciais da classe
     */
    public function __construct()
    {
        $this->baseUrl = Config::get('pix.api_url');
        $this->clientId = Config::get('pix.api_client_id');
        $this->clientSecret = Config::get('pix.api_client_secret');
        $this->certificate = Config::get('pix.api_certificate');
    }

    /**
     * Método responsável por criar uma cobrança imediata
     * @param  string $txid
     * @param  array $request
     * @return array
     */
    public function createCob($txid, $request)
    {
        // Adicione este log para verificar os dados da solicitação antes de enviar
        error_log('Dados da solicitação para criar cobrança: ' . json_encode($request));

        // Chame o método 'send'
        $response = $this->send('PUT', '/v2/cob/' . $txid, $request);

        // Adicione este log para verificar a resposta da API após o envio
        error_log('Resposta da API ao criar cobrança: ' . json_encode($response));

        return $response;
    }

    /**
     * Método responsável por consultar uma cobrança imediata
     * @param  string $txid
     * @return array
     */
    public function consultCob($txid)
    {
        return $this->send('GET', '/v2/cob/' . $txid);
    }

    /**
     * Método responsável por obter o token de acesso às APIs Pix
     * @return string
     */
    private function getAccessToken()
    {
        
    //ENDPOINT COMPLETO
    $endpoint = $this->baseUrl.'/oauth/token';

    //HEADERS
    $headers = [
      'Content-Type: application/json'
    ];

    //CORPO DA REQUISIÇÃO
    $request = [
      'grant_type' => 'client_credentials'
    ];
   
    //CONFIGURAÇÃO DO CURL
    $curl = curl_init();

      // echo '<pre>';
      // print_r($this->certificate);
      // echo '</pre>';

    curl_setopt_array($curl,[
      CURLOPT_URL            => $endpoint,
      CURLOPT_USERPWD        => $this->clientId.':'.$this->clientSecret,
      CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_CUSTOMREQUEST  => 'POST',
      CURLOPT_POSTFIELDS     => json_encode($request),
      CURLOPT_SSLCERT        => $this->certificate,
      CURLOPT_SSLCERTPASSWD  => '',
      CURLOPT_CAINFO => 'C:\Users\isaqu\OneDrive\Documentos\Clone Git Hub Projeto Integração Api PIX com Atualização de Status\wdev-qrcode-pix-php\files\certificates\cacert.pem',
      CURLOPT_SSL_VERIFYPEER => true,
      CURLOPT_HTTPHEADER     => $headers
    ]);

    if (curl_errno($curl)) {
      echo 'Erro cURL: ' . curl_error($curl);
  }
  
    //EXECUTA O CURL
    $response = curl_exec($curl);

//////////////////////////////////
// Verificar se houve algum erro
if (curl_errno($curl)) {
  echo 'Erro cURL: ' . curl_error($curl);
}

// Obter informações detalhadas sobre a requisição
$info = curl_getinfo($curl);

//  echo '<pre>';
//  print_r($info);
//  echo '</pre>';
///////////////////////////

    curl_close($curl);
    
    //RESPONSE EM ARRAY
    $responseArray = json_decode($response,true);

///////////////////////////

if ($responseArray === null && json_last_error() !== JSON_ERROR_NONE) {
  echo 'Erro ao decodificar a resposta JSON.';
} else {
  // Exibe json com Token e mais algumas propriedades
  // echo '<pre>';
  // print_r($responseArray);
  // echo '</pre>';
}

/////////////////////////
    
    //RETORNA O ACCESS TOKEN
    return $responseArray['access_token'] ?? '';
    }

    /**
     * Método responsável por enviar requisições para o PSP
     * @param  string $method
     * @param  string $resource
     * @param  array  $request
     * @return array
     */
    private function send($method, $resource, $request = [])
    {
              // ENDPOINT COMPLETO
      $endpoint = $this->baseUrl . $resource;
  
      // HEADERS
      $headers = [
          'Cache-Control: no-cache',
          'Content-type: application/json',
          'Authorization: Bearer ' . $this->getAccessToken()
      ];
  
      // CONFIGURAÇÃO DO CURL
      $curl = curl_init();
      curl_setopt_array($curl, [
          CURLOPT_URL            => $endpoint,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_CUSTOMREQUEST  => $method,
          CURLOPT_SSLCERT        => $this->certificate,
          CURLOPT_SSLCERTPASSWD  => '',
          CURLOPT_CAINFO => 'C:\Users\isaqu\OneDrive\Documentos\Clone Git Hub Projeto Integração Api PIX com Atualização de Status\wdev-qrcode-pix-php\files\certificates\cacert.pem',
          CURLOPT_SSL_VERIFYPEER => true,
          CURLOPT_HTTPHEADER     => $headers
      ]);
  
      // ADICIONE ESSA LINHA PARA ATIVAR A VERIFICAÇÃO SSL
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
  
      switch ($method) {
          case 'POST':
          case 'PUT':
              curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request));
              break;
      }
  
      // EXECUTA O CURL
      $response = curl_exec($curl);
  
      // VERIFICA SE HOUVE ERRO NO CURL
      if (curl_errno($curl)) {
          // ADICIONE UM LOG DE ERRO PARA DEBUGAR
          error_log('Erro cURL: ' . curl_error($curl));
          // TALVEZ VOCÊ QUEIRA LANÇAR UMA EXCEÇÃO AQUI OU REALIZAR OUTRA LÓGICA DE TRATAMENTO DE ERRO
      }
  
      // OBTÉM INFORMAÇÕES DETALHADAS SOBRE A REQUISIÇÃO
      $info = curl_getinfo($curl);
  
      // IMPRIME INFORMAÇÕES DETALHADAS
      error_log('Detalhes da requisição cURL: ' . json_encode($info));
  
      // FECHA A CONEXÃO cURL
      curl_close($curl);
  
      // RETORNA O ARRAY DA RESPOSTA
      return json_decode($response, true);
    }
}
