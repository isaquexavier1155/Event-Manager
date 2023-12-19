@extends('layouts.main')

@section('title', 'Rifas Douro')

@section('content')

    <!-- Conteudo Central -->
    <div class="conteudo-central">
        <div class="centralized-content">
            <h1>Bem vindo {{ $userName }}</h1>
        </div>
       
        <div class="centralized-content2">
          <span>Crie sua rifa e atinja seus objetivos rapidamente!</span>
        </div>
    </div>
    <!-- Conteudo Central -->

    <div id="event-create-container" class="col-md-6 offset-md-3">
    <form action="/rifas" method="POST" enctype="multipart/form-data" id="form-act"> 
        @csrf
        <!-- <div class="form-group">
           <label for="image">Imagem do Evento:</label> 
           <input type="file" id="image" name="image" class="from-control-file">
        </div> -->
        <div class="form-group">
           <label for="nome_campanha">Nome da campanha:</label> 
           <input type="text" class="form-control" id="nome_campanha" name="nome_campanha" placeholder="Nome da campanha">
        </div>

        <div class="form-group">
           <label for="quantidade_bilhetes">Quantidade de bilhetes</label> 
           <select name="quantidade_bilhetes" id="quantidade_bilhetes" class="form-control">
                <option value="0">Selecione uma opção</option>
                <option value="20">20 bilhetes - (00 à 20)</option>
                <option value="50">50 bilhetes - (00 à 50)</option>
                <option value="100">100 bilhetes - (00 à 100)</option>
                <option value="200">200 bilhetes - (00 à 200)</option>
                <option value="300">300 bilhetes - (00 à 300)</option>
                <option value="400">400 bilhetes - (00 à 400)</option>
                <option value="500">500 bilhetes - (00 à 500)</option>
                <option value="1000">1000 bilhetes - (00 à 1000)</option>
                <option value="5000">5000 bilhetes - (00 à 5000)</option>
                <option value="10000">10000 bilhetes - (00 à 10000)</option>
                <option value="50000">50000 bilhetes - (00 à 50000)</option>
                <option value="100000">100000 bilhetes - (00 à 100000)</option>
                <option value="500000">500000 bilhetes - (00 à 500000)</option>
           </select>
        </div>

        <div class="form-group">
            <label for="valor_bilhetes">Valor do Bilhete:</label>
            <input type="text" class="form-control" id="valor_bilhetes" name="valor_bilhetes" placeholder="0,00">
        </div>

        <div class="form-group">
           <label for="local_sorteio">Onde será o sorteio?</label> 
           <select name="local_sorteio" id="local_sorteio" class="form-control">
                <option value="00">Selecione uma opção</option>
                <option value="01">Loteria Federal</option>
                <option value="02">Live no Youtube</option>
                <option value="03">Live no Facebook</option>
                <option value="04">Live no Istagram</option>
                <option value="05">Live no TikTok</option>
                <option value="06">Sorteador.com.br</option>
                <option value="07">Outro</option>
           </select>
        </div>
        <div class="form-group">
            <label for="telefone">Telefone (com código postal):</label>
            <input type="text" class="form-control" id="telefone" name="telefone" placeholder="(11)11111-1111">
        </div>

        <div id="arrecadacao-estimada-container" >
        </div>
        <div id="taxa-publicacao-container">
        </div>

        <!-- Geração de código e Qr Code Pix -->
        <!-- <h1>QR CODE PIX</h1>
        <br>
        <img src="data:image/png;base64, {{ $image }}">
        <br><br>
        Código PIX:<br>
        <strong>{{ $payloadQrCode }}</strong> -->
        <!-- Geração de código e Qr Code Pix -->

        <br>
        <input type="submit" class="btn btn-primary" value="Avançar">
    </form>
</div>

<!-- Script de cálculo de Arrecadação e Taxa de publicação -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        var quantidadeBilhetes = 0;
        var valorBilhetes = 0;

        $('#quantidade_bilhetes').on('blur', function() {
            quantidadeBilhetes = parseFloat($(this).val()) || 0;
            calcularArrecadacaoEstimada();
            $('#quantidade-bilhetes-container').text('Quantidade de Bilhetes: R$ ' + quantidadeBilhetes);
        });

        $('#valor_bilhetes').on('blur', function() {
            
            valorBilhetes = parseFloat($(this).val().replace(/[^\d.,-]/g, '').replace(',', '.')) || 0;
            calcularArrecadacaoEstimada();
            $('#valor-bilhetes-container').text('Valor dos Bilhetes: R$ ' + valorBilhetes.toFixed(2));
        });

        function calcularArrecadacaoEstimada() {
            var arrecadacaoEstimada = quantidadeBilhetes * valorBilhetes;
            $('#arrecadacao-estimada-container').text('Arrecadação Estimada: R$ ' + '+' +arrecadacaoEstimada.toFixed(2));

            var porcentagemTaxaPublicacao = 6; // substitua pela porcentagem calculada
            var taxaPublicacao = (porcentagemTaxaPublicacao / 100) * arrecadacaoEstimada;
            $('#taxa-publicacao-container').text('Taxa de Publicação: R$ '+ '-' + taxaPublicacao.toFixed(2));
        }
    });
</script>

@endsection