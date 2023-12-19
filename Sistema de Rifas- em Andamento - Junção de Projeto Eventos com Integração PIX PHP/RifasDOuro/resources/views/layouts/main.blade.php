<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>

        <!-- Fonte do Google -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles:wght@700&family=Oswald:wght@200&family=Roboto" rel="stylesheet">

        <!-- Links do Projeto Rifa -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-vzO5T3WM9V9HDr5Os93u9ZxEpSVL95rW8TlVc+3RqgpacJYYR38xGo/EItrD18+qlAEwEcU/J3pU2H27edWMAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <link rel="shortcut icon" href="/imagens/icon2.png" type="image/x-icon">

        <!-- CSS Bootstrap -->
        <!-- Está bloqueando a rolagem -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        
        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/style_rifas.css">
        <script src="/js/script.js"></script>

        
    </head>
    <body> 
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="collapse navbar-collapse" id="navbar">
                <a href="" class="nvbar-brand">
                    <img src="/img/icone.jpeg" alt="logo">
                </a>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="/" class="nav-link">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a href="/events/create" class="nav-link">Criar Rifa</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link">Minhas rifas</a>
                    </li>
                    <li class="nav-item">
                        <form action="/logout" method="POST">
                            @csrf
                            <a href="/logout" 
                                class="nav-link" 
                                onclick="event.preventDefault();
                                this.closest('form').submit();">
                                Sair
                            </a>
                        </form>
                    </li>
                    @endauth
                    @guest
                    <li class="nav-item">
                        <a href="/login" class="nav-link">Entrar</a>
                    </li>
                    <li class="nav-item">
                        <a href="/register" class="nav-link">Cadastrar</a>
                    </li>
                    @endguest
                </ul>
            </div>
        </nav>

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
            <li class="item-menu @if(request()->is('home')) ativo @endif">
                <a href="/home">
                    <span class="icon"><i class="bi bi-house-door"></i></span>
                    <span class="txt-link">Home</span>
                </a>
            </li>
            <li class="item-menu @if(request()->is('rifas/create_rifa')) ativo @endif">
                <a href="/rifas/create_rifa">
                    <span class="icon"><i class="bi bi-columns-gap"></i></span>
                    <span class="txt-link">Rifas</span>
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
    </header>

        <!-- mudar conteudo dinamicamente -->
    
        <main>
            <div class="container-fluid">
                <div class="row">
                    @if(session('msg'))
                    <p class="msg">{{ session('msg') }}</p>
                    @endif
                    @yield('content') 
                </div> 
            </div>
        </main>
    <!-- <footer>
        <p>Rifa Chance D'ouro &copy; 2023</p>
    </footer> -->
        <!-- utilização de ícones externos -->
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <!-- Novos Scripts hoje -->
        <script src="/js/script.js"></script>

        {{-- Inclua o jQuery e o Inputmask --}}
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>

        {{-- Inclusão do jQuery e o Inputmask --}}
        <script src="{{ asset('node_modules/jquery/dist/jquery.min.js') }}"></script>

        {{-- Máscara de telefone --}}
        <script>
            $(document).ready(function () {
                $('#telefone').inputmask('(99)99999-9999');
            });
        </script>

        {{-- Máscara de Valor do bilhete --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var ticketValueInput = document.getElementById('valor_bilhetes');

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
    </body>
</html>
