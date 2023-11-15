
    @extends('layouts.main')
    @section('title', 'HDC Events')
    @section('content')

        <h1>Eventos Tecnologia</h1>
        <img src="/img/banner.jpg" alt="Banner">

    @if(10 > 5)
        <p>A condição é true</p>
    @endif

     <p> {{ $nome }} </p>  
     @if($nome == "Isaque")
        <p>O nome é Isaque</p>
     @else
        <p>O nome não é Isaque</p>
     @endif

     {{-- For --}}
     @for($i = 0; $i < count($arr); $i++)
        <p>{{ $arr[$i] }} - {{ $i }}</p>
        @if($i == 2)
        <p>I é igual a Dois</p>
        @endif
     @endfor

     {{--para executar php puro em BLADE- Não aparece nada no HTML--}}
     @php 
        $name = "Isaque";
        echo($name);
        for($i = 0; $i < count($arr); $i++){
            echo($arr[$i]);
            if($i == 2)
            echo("E igual");
        } 
     @endphp

     {{-- For Each --}}
     @foreach($nomes as $nome)
        <p>{{ $loop->index }}</p>
        <p>{{ $nome }}</p>
     @endforeach

     @endsection
        
