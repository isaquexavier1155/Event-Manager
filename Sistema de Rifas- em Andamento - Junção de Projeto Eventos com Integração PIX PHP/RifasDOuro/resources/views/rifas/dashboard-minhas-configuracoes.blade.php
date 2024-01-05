@extends('layouts.main')

@section('title', 'Minhas Rifas')

@section('content')

<div class="conteudo-central">
    <div class="centralized-content2">
        <h3>Dados Pessoais: </h3><br><br>

        <div class="col-md-10 offset-md-1 col-12 dashboard-events-container ml-10">
            @if(count($users) > 0)
            <div class="card-deck justify-content-center">
                @foreach($users as $user)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Nome: {{ $user->name }}</h5>
                        <h5 class="card-text">Email: {{ $user->email }}</h5>
                        <h5 class="card-text">Chave PIX: {{ $user->chave_pix }}</h5>
                        <!-- <button class="btn btn-info btn-block" data-toggle="modal" data-target="#linkModal{{ $user->id }}">
                            Gerar link
                        </button> -->
                        <button class="btn btn-primary btn-block mt-2" data-toggle="modal" data-target="#editModal{{ $user->id }}">
                            Editar
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            @else
            <div class="alert alert-info" role="alert">
                <span>Você ainda não tem rifas Ativas! <a href="/rifas/create_rifa">Crie uma rifa agora</a></span>
            </div>
            @endif
        </div>

    </div>
</div>

@foreach($users as $user)
    <!-- <div class="modal fade" id="linkModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="linkModalLabel{{ $user->id }}" aria-hidden="true"> -->
        <!-- ... (código do modal de link) -->
    <!-- </div> -->

    <!-- Adicione o modal de edição aqui -->
    <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $user->id }}">Editar Usuário</h5>
                    <button type="button" class="close custom-close-button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulário de edição aqui -->
                    <form action="{{ route('users.update', ['id' => $user->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Campos de edição -->
                        <div class="form-group">
                            <label for="editName{{ $user->id }}">Nome:</label>
                            <input type="text" class="form-control" id="editName{{ $user->id }}" name="name" value="{{ $user->name }}">
                        </div>

                        <div class="form-group">
                            <label for="editEmail{{ $user->id }}">Email:</label>
                            <input type="email" class="form-control" id="editEmail{{ $user->id }}" name="email" value="{{ $user->email }}">
                        </div>

                        <div class="form-group">
                            <label for="editPix{{ $user->id }}">Chave PIX:</label>
                            <input type="chave_pix" class="form-control" id="editPix{{ $user->id }}" name="chave_pix" value="{{ $user->chave_pix }}">
                        </div>

                        <!-- Botão de submit -->
                        <button type="submit" class="btn btn-primary btn-block">Salvar Alterações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

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
