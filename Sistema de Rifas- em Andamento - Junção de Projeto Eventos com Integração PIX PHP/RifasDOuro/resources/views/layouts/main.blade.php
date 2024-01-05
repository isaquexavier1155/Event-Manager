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
        <link rel="shortcut icon" href="/img/icon-ft3.png" type="image/x-icon">

        <!-- Efeito mostrar mais números comprar-bilhetes.blade.php -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


        <!-- JS que faz efeito de botão copiar codigo pix da página de pagamento de taxa de publicação -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
        
        <!-- Adicione o script JavaScript para Clipboard.js e atualização de página -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>

        <!-- Bootstrap JS para exibir modal de pagamento realizado com sucesso em payment-fee-publication-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Scrip responsavel por efeito de importar editor de texto -->
        <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>


        <!-- CSS Bootstrap -->
        <!-- Está bloqueando a rolagem -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        
        <link rel="stylesheet" href="/css/style_rifas.css">
        <script src="/js/script.js"></script>
    </head>
    <body> 
        <header>
            <!-- MENU LATERAL -->
            <nav class="menu-lateral">
            
                <div class="btn-expandir">
                    <i class="bi bi-list" id="btn-exp"></i>
                </div><!--btn-expandir-->
            
                <ul>
                    <div id="menu-title">
                        Rifa Chance D'ouro
                        <div id="menu-icon">
                        <ion-icon name="podium-outline"></ion-icon>
                        </div>
                    </div>
                    <br><br>

                    <li class="item-menu @if(request()->is('dashboard-minhas-rifas')) ativo @endif">
                        <a href="/dashboard-minhas-rifas">
                            <span class="icon"><i class="bi bi-person-square"></i></span>
                            <span class="txt-link">Rifas</span>
                        </a>
                    </li>
                    <li class="item-menu @if(request()->is('rifas/create_rifa')) ativo @endif">
                        <a href="/rifas/create_rifa">
                            <span class="icon"><i class="bi bi-plus-circle-dotted"></i></span>
                            <span class="txt-link">Criar</span>
                        </a>
                    </li>

                    <li class="item-menu">
                        <a href="#">
                            <span class="icon"><i class="bi bi-calendar3"></i></span>
                            <span class="txt-link">Tutorial</span>
                        </a>
                    </li>
                    <li class="item-menu @if(request()->is('dashboard-minhas-configuracoes')) ativo @endif">
                        <a href="/dashboard-minhas-configuracoes">
                            <span class="icon"><i class="bi bi-gear"></i></span>
                            <span class="txt-link">Configurações</span>
                        </a>
                    </li>
                    @auth
                    <li class="item-menu">
                        <form action="/logout" method="POST">
                            @csrf
                            <a href="/logout" 
                                class="nav-link" 
                                onclick="event.preventDefault();
                                this.closest('form').submit();">
                            <span class="icon"><i class="bi bi-escape"></i></span>
                            <span class="txt-link">Sair</span>
                            </a>
                        </form>
                    </li>
                    @endauth
                    @guest
                    <li class="item-menu">
                        <a href="/login" class="nav-link">
                            <span class="icon"><i class="bi bi-building-up"></i></span>
                            <span class="txt-link">Entrar</span>
                        </a>
                    </li>
                    <li class="item-menu">
                        <a href="/register" class="nav-link">
                            <span class="icon"><i class="bi bi-plus"></i></span>
                            <span class="txt-link">Cadastrar</span>
                        </a>
                    </li>
                    @endguest
                </ul>
            </nav>
            <!--FIM MENU LATERAL-->
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
