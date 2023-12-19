@extends('layouts.main')

@section('title', 'Rifas Douro')

@section('content')

<!-- Conteudo Central -->

<div class="conteudo-central">
        <div class="centralized-content">
            <h2>Pagamento de taxa de publicação</h2>
        </div>
       
        <div class="centralized-content2">
          <span>Realize o pagamento para finalizar sua rifa!</span>
        </div>
    </div>

<div id="event-create-container" class="col-md-6 offset-md-3">
    <br>
    <img src="data:image/png;base64, {{ $image }}">
    <br><br>
    Código PIX:<br>


    <strong>{{ $payloadQrCode }}</strong>

    <form action="/rifas" method="POST" enctype="multipart/form-data" id="form-act"> 
        @csrf
        <input type="submit" class="btn btn-primary" value="Finalizar">
    </form>
</div>

<!-- Conteudo Central -->

@endsection
