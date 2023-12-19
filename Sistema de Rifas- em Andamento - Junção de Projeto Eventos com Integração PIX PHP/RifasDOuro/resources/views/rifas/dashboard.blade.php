@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

<div class="col-md-10 offset-md-1 dashboard-title-container">
    <h1>Minhas Rifas</h1>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
    @if(count($rifas) > 0)
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome Campanha</th>
                <th scope="col">Quantidade de Bilhetes</th>
                <th scope="col">Valor dos Bilhetes</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
    
        <tbody>
            @foreach($rifas as $rifa)
                <tr>
                    <td scope="row">{{  $loop->index + 1 }}</td>
                    <td><a href="/rifas/{{ $rifa->id }}">{{ $rifa->nome_campanha }}</a></td>
                    <td><a href="/rifas/{{ $rifa->id }}">{{ $rifa->quantidade_bilhetes }}</a></td>
                    <td><a href="/rifas/{{ $rifa->id }}">{{ $rifa->valor_bilhetes }}</a></td>
                    <td>
                        <a href="/rifas/edit/{{ $rifa->id }}" class="btn btn-info edit-btn"><ion-icon name="create-outline"></ion-icon> Editar</a>
                        <form action="/rifas/{{ $rifa->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-btn"><ion-icon name="trash-outline"></ion-icon> Deletar</button>
                        </form>
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>Você ainda não tem eventos, <a href="/rifas/create">Criar evento</a></p>
    @endif
</div>


@endsection