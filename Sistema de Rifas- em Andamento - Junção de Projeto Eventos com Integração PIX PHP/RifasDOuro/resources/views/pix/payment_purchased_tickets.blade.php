@extends('layouts.main')

@section('title', 'Rifas Douro')

@section('content')

<!-- INICIO //////////////////////////////////////////////// -->
<!-- Conteudo Central -->
    <div class="conteudo-central">
        <div class="centralized-content"><br>
            <h3>Pagamento dos bilhetes Escolhidos</h3><br><br><br>
            <h5>Ao realizar o pagamento </h5>
            <h5>você será redirecionado para a próxima página</h5>
        </div>
        
        <div class="centralized-content2">
            
            <strong id="arrecadacao">Valor a ser pago: R$ {{ $valorSerPago }} </strong>
            <br><br>
            <strong id="escaneie">ESCANEIE O QRCODE</strong>

        </div>
        <div class="centralized-content2">
            <h4>Status do pagamento:</h4>
            <strong id="statusCobranca"> $statusCobranca </strong>
        </div>
        <div class="centralized-content2">
            <img src="data:image/png;base64, {{ $image }}" class="img-fluid">
        </div>
        <div class="centralized-content2"><br>
            <h5>OU</h5> <br>
            <h5>1 - Copie o código PIX</h5><br>
            <h5>2 - Abra o aplicativo do seu banco e escolha a opção Pix Copia e Cola</h5><br>
            <h5>3 - Efetue o pagamento</h5><br><br>
            <h6 id="payloadQrCode">{{ $payloadQrCode }}</h6><br><br>
            <button class="btn btn-secondary btn-copy" data-clipboard-target="#payloadQrCode">Copiar Código PIX</button>  
        </div>
    </div>
    <!-- Conteudo Central -->
<!-- FIM /////////////////////////////////////////////// -->

<!-- Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Pagamento efetuado com sucesso!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Você será redirecionado as suas rifas!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="redirecionarParaHome()">OK</button>
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 767px) {
    .conteudo-central {
        position: absolute !important;
        top: 60% !important;
    }
}
</style>
<!-- Conteudo Central -->
@endsection

<!-- Script de botão copiar qrcode -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var clipboard = new ClipboardJS('.btn-copy');

        clipboard.on('success', function (e) {
            alert('Código copiado com sucesso!');
            e.clearSelection();
        });

        clipboard.on('error', function (e) {
            alert('Erro ao copiar o código. Por favor, selecione e copie manualmente.');
        });
    });
</script>

<!-- Script para verificação periódica -->
<script>
  setInterval(function () {
    atualizarStatusCobranca();
  }, 5000);

  function atualizarStatusCobranca() {
    fetch('/consult-qrcode')
      .then(response => response.json())
      .then(data => {
        console.log('Resposta da API:', data);

        var statusCobrancaElement = document.getElementById('statusCobranca');

        if (data.status) {
          console.log('Status atual:', statusCobrancaElement.innerText);
          console.log('Status recebido:', data.status);

          // Atualizar o elemento com o novo status
          statusCobrancaElement.innerText = data.status;

          if (data.status === 'CONCLUIDA') {
            console.log('Exibindo modal de sucesso');
            
            // Exibir o modal de sucesso
            $('#successModal').modal('show');
          } else {
            console.log('Status diferente de CONCLUIDA. Status:', data.status);
          }
        }
      })
      .catch(error => console.error('Erro ao obter o status da cobrança:', error));
  }

  function redirecionarParaHome() {
    window.location.href = '/dashboard-minhas-rifas';
  }
</script>




