@extends('layouts.main')

@section('title', 'Minhas Rifas')

@section('content')

    <!-- Conteudo Central -->
    <div class="conteudo-central">
        <div class="centralized-content2">
            <span>Clique no botão abaixo para gerar o link de publicação.</span><br><br> 
        </div>
    </div>
    <!-- Conteudo Central -->

    <div class="col-md-10 offset-md-1 col-12 dashboard-events-container" id="id-tabela-minhas-rifas">
        @if(count($rifas) > 0)
        <div class="table-responsive" style="overflow: auto;">
            <table class="table table-bordered table-striped text-center" style="font-size: 0.9rem;">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Nome Campanha</th>
                        <th scope="col">Quantidade de Bilhetes</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
            
                <tbody>

                    @foreach($rifas as $rifa)
                        <tr>
                            <td>{{ $rifa->nome_campanha }}</td>
                            <td>{{ $rifa->quantidade_bilhetes }}</td>
                            <td>
                                <button class="btn btn-info edit-btn" data-toggle="modal" data-target="#linkModal{{ $rifa->id }}">
                                    Gerar link  
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
       
        @else
        <div class="alert alert-info" role="alert">
            <span>Você ainda não tem rifas Ativas! <a href="/rifas/create_rifa">Crie uma rifa agora</a></span>
        </div>
        @endif
    </div>

<!-- modal -->
@foreach($rifas as $rifa)
    <div class="modal fade" id="linkModal{{ $rifa->id }}" tabindex="-1" role="dialog" aria-labelledby="linkModalLabel{{ $rifa->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="linkModalLabel{{ $rifa->id }}">Link de Publicação</h5>
                    <button type="button" class="close custom-close-button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p> <span id="exampleLink{{ $rifa->id }}">http://seu-site.com/rifas/{{ $rifa->id }}/publicacao</span></p>
                    <button class="btn btn-primary" onclick="copyToClipboard('exampleLink{{ $rifa->id }}')">Copiar</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

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

<!-- Adicione os seguintes scripts caso ainda não estejam incluídos em sua aplicação -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
