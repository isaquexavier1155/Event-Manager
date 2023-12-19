@extends('layouts.main')

@section('title', 'Rifas Douro')

@section('content')

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
    <form action="/rifas" method="POST" enctype="multipart/form-data" id="form-act"> 
        @csrf
        <input type="submit" class="btn btn-primary" value="Vamos lá">
    </form>
</div>
      
@endsection