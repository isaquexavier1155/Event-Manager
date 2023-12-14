@extends('layouts.main')

@section('title', 'Rifas Douro')

@section('content')


<nav class="menu-lateral">
        <!-- Seu código da barra lateral aqui -->
        <div class="btn-expandir">
            <i class="bi bi-list" id="btn-exp"></i>
        </div><!--btn-expandir-->
        
        <ul>
            <div id="menu-title">
                Rifa Chance D'ouro
                <div id="menu-icon">
                  <ion-icon name="podium-outline"></ion-icon><!-- Ícone -->
                </div>
            </div>
            <br><br>
            <li class="item-menu ativo">
                <a href="#">
                    <span class="icon"><i class="bi bi-house-door"></i></span>
                    <span class="txt-link">Home</span>
                </a>
            </li>
            <li class="item-menu">
                <a href="https://www.google.com.br/">
                    <span class="icon"><i class="bi bi-columns-gap"></i></span>
                    <span class="txt-link">Dashboard</span>
                </a>
            </li>
            <li class="item-menu">
                <a href="#">
                    <span class="icon"><i class="bi bi-person-circle"></i></span>
                    <span class="txt-link">Conta1</span>
                </a>
            </li>
            <li class="item-menu">
                <a href="#">
                    <span class="icon"><i class="bi bi-calendar3"></i></span>
                    <span class="txt-link">Agenda</span>
                </a>
            </li>
            <li class="item-menu">
                <a href="#">
                    <span class="icon"><i class="bi bi-gear"></i></span>
                    <span class="txt-link">Configurações</span>
                </a>
            </li>

            <li class="item-menu">
                <a href="#">
                    <span class="icon"><i class="bi bi-person-circle"></i></span>
                    <span class="txt-link">Conta2</span>
                </a>
            </li>
            <li class="item-menu">
                <a href="#">
                    <span class="icon"><i class="bi bi-person-circle"></i></span>
                    <span class="txt-link">Conta3</span>
                </a>
            </li>
        </ul>
    </nav><!--menu-lateral-->

    <!-- Conteudo Central -->
    <div class="conteudo-central">
        <div class="centralized-content">
            <h1>Bem vindo Isaque!</h1>
        </div>
       
        <div class="centralized-content2">
          <span>Nessa tela você poderá criar uma rifa de maneira segura!</span>
        </div>
    </div>
    <!-- Conteudo Central -->

    <div id="event-create-container" class="col-md-6 offset-md-3">
    <form action="/events" method="POST" enctype="multipart/form-data" id="form-act"> 
        @csrf
        <!-- <div class="form-group">
           <label for="image">Imagem do Evento:</label> 
           <input type="file" id="image" name="image" class="from-control-file">
        </div> -->
        <div class="form-group">
           <label for="title">Nome da campanha:</label> 
           <input type="text" class="form-control" id="title" name="title" placeholder="Nome da campanha">
        </div>

        <div class="form-group">
           <label for="title">Quantidade de bilhetes</label> 
           <select name="private" id="private" class="form-control">
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
            <label for="ticketValue">Valor do Bilhete:</label>
            <input type="text" class="form-control" id="ticketValue" name="ticketValue" placeholder="0,00">
        </div>

        <div class="form-group">
           <label for="title">Onde será o sorteio?</label> 
           <select name="private" id="private" class="form-control">
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
            <label for="phone">Telefone (com código postal):</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="(11)11111-1111">
        </div>
        <!-- <div class="form-group">
           <label for="title">Descrição:</label> 
           <textarea name="description" id="description" class="form-control" placeholder="O que vai acontecer no evento?"></textarea>
        </div> -->

        <input type="submit" class="btn btn-primary" value="Criar Evento">
    </form>
</div>

{{-- Inclua o jQuery e o Inputmask --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>

{{-- Máscara de telefone --}}
<script>
    $(document).ready(function () {
        $('#phone').inputmask('(99)99999-9999');
    });
</script>

{{-- Máscara de Valor do bilhete --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ticketValueInput = document.getElementById('ticketValue');

        ticketValueInput.addEventListener('input', function () {
            var inputValue = ticketValueInput.value.replace(/[^\d]/g, ''); // Remove caracteres não numéricos
            var formattedValue = formatCurrency(inputValue);
            ticketValueInput.value = formattedValue;
        });

        function formatCurrency(value) {
            if (!value) {
                return '0,00';
            }

            var number = parseInt(value, 10) / 100;
            return number.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        }
    });
</script>




    
    
@endsection