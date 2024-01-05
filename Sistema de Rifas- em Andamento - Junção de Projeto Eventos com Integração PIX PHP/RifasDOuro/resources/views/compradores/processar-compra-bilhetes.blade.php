<!-- resources/views/compradores/processar-compra-bilhetes.blade.php -->
@extends('layouts.main')

@section('title', 'Processar Compra de Bilhetes')

@section('content')

<!-- Conteudo Central -->
<div id="event-create-container" class="col-md-6 offset-md-3">
    <div class="centralized-content1"><br>
        <h3>Processar Compra de Bilhetes</h3>
    </div>
    <h5>ID RIFA:</h5><p>{{ $idCampanha }}</p>
    
    @if ($numerosSelecionados)
    @if (is_array($numerosSelecionados))
        <p>Números Selecionados: {{ implode(',', $numerosSelecionados) }}</p>
    @else
        <p>Número Selecionado: {{ $numerosSelecionados }}</p>
    @endif
    @endif
    
    <form action="/payment-purchased-tickets" method="POST" enctype="multipart/form-data" id="form-act">
        @csrf
        <div class="form-group">
            <label for="nome_completo">Nome Completo:</label>
            <input type="text" name="nome_completo" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="repeticao_telefone">Repetir Telefone:</label>
            <input type="text" name="repeticao_telefone" class="form-control" required>
        </div>
        <div class="form-group">
            <!-- <label for="numeros_escolhidos">Números Escolhidos:</label> -->
            <input type="hidden" name="numeros_escolhidos" value="{{ is_array($numerosSelecionados) ? implode(',', $numerosSelecionados) : $numerosSelecionados }}">
        </div>
        <div class="form-group">
            <!-- <label for="numeros_escolhidos">Números Escolhidos:</label> -->
            <input type="hidden" name="id_campanha" value="{{ $idCampanha }}">
        </div>
            <button type="submit" class="btn btn-primary">Finalizar Compra</button>
        </form>
    </div>
@endsection
