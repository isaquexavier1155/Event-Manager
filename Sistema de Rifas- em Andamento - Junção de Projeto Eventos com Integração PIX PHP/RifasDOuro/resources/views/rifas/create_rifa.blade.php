@extends('layouts.main')

@section('title', 'Rifas Douro')

@section('content')

    <!-- Conteudo Central -->
    <div class="conteudo-central">
        <div class="centralized-content">
            <h2>Bem vindo {{ htmlspecialchars($userName) }}</h2>
        </div>
       
        <div class="centralized-content2">
            <span>Crie sua rifa e atinja seus objetivos rapidamente!</span>
        </div>
    </div>
    <!-- Conteudo Central -->

    <div id="event-create-container" class="col-md-6 offset-md-3">
        <!-- Se houver erros de validação, exiba mensagens de erro -->
        @if($errors->has('imagem'))
            <div class="alert alert-danger">
                {{ $errors->first('imagem') }}
            </div>
        @endif
        @if($errors->has('nome_campanha'))
            <div class="alert alert-danger">
                {{ $errors->first('nome_campanha') }}
            </div>
        @endif
        @if($errors->has('descricao'))
            <div class="alert alert-danger">
                {{ $errors->first('descricao') }}
            </div>
        @endif
        @if($errors->has('quantidade_bilhetes'))
            <div class="alert alert-danger">
                {{ $errors->first('quantidade_bilhetes') }}
            </div>
        @endif
        @if($errors->has('valor_bilhetes'))
            <div class="alert alert-danger">
                {{ $errors->first('valor_bilhetes') }}
            </div>
        @endif

        <form action="/payment-fee-publication" method="POST" enctype="multipart/form-data" id="form-act"> 
            @csrf
            <div class="form-group">
                <label for="nome_campanha">Nome da campanha:</label> 
                <input type="text" class="form-control" id="nome_campanha" name="nome_campanha" placeholder="Nome da campanha" value="Rifa de teste" required>
            </div>
            <div class="form-group">
                <label for="imagem">Imagem (máximo 4MB)</label><br> 
                <input type="file" class="form-control" id="imagem" name="imagem" onchange="previewImage()">
                <img id="preview" src="#" alt="Preview da imagem" style="display: none; max-width: 100%; margin-top: 10px;">
            </div>
            <div class="form-group">
                <label for="descricao">Descrição/Regulamento:</label> 
                <textarea name="descricao" id="descricao" class="form-control" placeholder="Sorteio será realizado em live do Tik Tok; Sorteio será realizado dia 20/12" ></textarea>
                <script>
                    CKEDITOR.replace('descricao', {
                        // Adicione outras configurações conforme necessário
                    });
                </script>
            </div>

            <div class="form-group">
                <label for="quantidade_bilhetes">Quantidade de bilhetes</label> 
                <select name="quantidade_bilhetes" id="quantidade_bilhetes" class="form-control" required>
                    <!-- <option value="">Selecione uma opção</option>  -->
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
                </select>
            </div>

            <div class="form-group">
                <label for="valor_bilhetes">Valor do Bilhete:</label>
                <input type="text" class="form-control" id="valor_bilhetes" name="valor_bilhetes" placeholder="0,00" value="0,50" required>
            </div>

            <div class="form-group">
                <label for="local_sorteio">Onde será o sorteio?</label> 
                <select name="local_sorteio" id="local_sorteio" class="form-control" required>
                    <!-- <option value="">Selecione uma opção</option> -->
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
                <input type="text" class="form-control" id="telefone" name="telefone" placeholder="(11)11111-1111" value="(51)99772-6349" required>
            </div>

            <div id="arrecadacao-estimada-container" >
            </div>
            <div id="taxa-publicacao-container">
            </div><br>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="terms_agreement" name="terms_agreement" required>
                    <label class="form-check-label" for="terms_agreement">
                        Eu concordo com os <a href="{{ url('/rifas/terms_of_use') }}" target="_blank">Termos de Uso</a> e a <a href="{{ url('/rifas/policy') }}" target="_blank">Política de Privacidade</a>.
                    </label>
                </div>
            </div><br>
            <input type="submit" class="btn btn-primary" value="Continuar">
        </form>
    </div>

    <!-- Script para exibir preview da imagem da campanha -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function previewImage() {
            var input = document.getElementById('imagem');
            var preview = document.getElementById('preview');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';

                    // Definir o tamanho da imagem de prévia
                    preview.style.width = '500px';
                    preview.style.height = '300px';
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }

        // <!-- Script de cálculo de Arrecadação e Taxa de publicação -->
        $(document).ready(function() {
            var quantidadeBilhetes = 0;
            var valorBilhetes = 0;

            $('#quantidade_bilhetes').on('blur', function() {
                quantidadeBilhetes = parseFloat($(this).val()) || 0;
                calcularArrecadacaoEstimada(quantidadeBilhetes, valorBilhetes);
                $('#quantidade-bilhetes-container').text('Quantidade de Bilhetes: R$ ' + quantidadeBilhetes);
            });

            $('#valor_bilhetes').on('blur', function() {
                valorBilhetes = parseFloat($(this).val().replace(/[^\d.,-]/g, '').replace(',', '.')) || 0;
                calcularArrecadacaoEstimada(quantidadeBilhetes, valorBilhetes);
                $('#valor-bilhetes-container').text('Valor dos Bilhetes: R$ ' + valorBilhetes.toFixed(2));
            });

            function formatarNumero(numero) {
                return numero.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }

            function calcularArrecadacaoEstimada(quantidadeBilhetes, valorBilhetes) {
                var arrecadacaoEstimada = quantidadeBilhetes * valorBilhetes;
                $('#arrecadacao-estimada-container').text('Arrecadação Estimada: R$ ' + formatarNumero(arrecadacaoEstimada));

                var porcentagemTaxaPublicacao = 6; // substitua pela porcentagem calculada
                var taxaPublicacao = (porcentagemTaxaPublicacao / 100) * arrecadacaoEstimada;
                $('#taxa-publicacao-container').text('Taxa de Publicação: R$ ' + formatarNumero(taxaPublicacao));
            }
        });
    </script>

@endsection
