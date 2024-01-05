@extends('layouts.main')

@section('title', 'Minhas Rifas')

@section('content')

<div class="conteudo-central">
    <div class="centralized-content2">
        <span>Clique no botão abaixo para gerar o link de publicação.</span><br><br>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function copyToClipboard(elementId) {
        var el = document.getElementById(elementId);
        var range = document.createRange();
        range.selectNodeContents(el);
        var selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
        document.execCommand('copy');
        alert('Link copiado para a área de transferência!');
    }
</script>

@endsection
