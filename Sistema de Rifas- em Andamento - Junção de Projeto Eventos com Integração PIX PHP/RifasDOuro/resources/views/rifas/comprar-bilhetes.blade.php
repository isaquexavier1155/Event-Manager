@extends('layouts.main')

@section('title', 'Rifas Douro')

@section('content')

<!-- Conteudo Central -->
<div class="conteudo-central">
    <div class="centralized-content1"><br>
        <h3>{{ $rifa->nome_campanha }}</h3>
         <p>Id da campanha:</p>
        <h3>{{ $rifa->id }}</h3>
    </div>

    <div class="centralized-content2">
        <h4>Status do pagamento:</h4>
    </div>
    <div class="centralized-content3">
        <!-- Certifique-se de que a variável $image existe antes de tentar acessá-la -->
        @if ($rifa->imagem)
            <img src="/img/rifas/{{ $rifa->imagem }}" class="img-fluid" alt="Imagem da Rifa" id="img-camp">
            <!-- <img src= "C:\Users\isaqu\AppData\Local\Temp\php4DE3.tmp"  class="img-fluid" alt="Imagem da Rifa"> -->
        @else
            <p>Nenhuma imagem disponível</p>
        @endif
    </div>
    <div class="centralized-content5"><br>
        <h5>Não Perca! </h5>
        <h5>Apenas: R$ {{ $valorBilhetesForm2 }}</h5>

    </div>
    <div class="centralized-content6"><br>
        {!! $rifa->descricao !!}
    </div>

        <div class="centralized-content1"><br>
        <!-- Não remover essa estrutura. Se remover não aparece nenhuma célula na tela -->
        <table id="tabela-bilhetes" class="tabela-bilhetes">
            <tbody>
            </tbody>
        </table>

        <div id="botoes-container">
            <button id="ver-menos-bilhetes" class="btn btn-primary">Voltar</button>
            <div id="paginas-container">
                <div class="linha-paginas" id="linha-1"></div>
                <div class="linha-paginas" id="linha-2" style="display: none;"></div>
            </div>
            <span id="mostrar-mais-paginas"><i class="bi bi-caret-down-fill"></i> </span>
            <button id="ver-mais-bilhetes" class="btn btn-primary">Próximo</button>
        </div>
    </div>
    <!-- Adicione isso ao seu HTML para exibir os números selecionados -->
    <div id="numeros-selecionados-container">
        <span id="numeros-selecionados">Números selecionados:</span><br>
        <span id="valor-a-ser-pago">Valor a ser pago:</span><br>
    </div>
    <!-- Adicione este código na sua view onde você deseja exibir os números escolhidos -->
    <div id="div-numeros-escolhidos"></div>

    <div id="aviso-numero-escolhido" style="color: red;"></div>


    <a href="{{ route('compradores.processar-compra-bilhetes') }}" class="btn btn-primary" id="btn-cont">Continuar</a>

</div>

    <!-- Conteudo Central -->
<!-- FIM /////////////////////////////////////////////// -->

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
    }

    .conteudo-central {
        max-width: 800px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        text-align: center;
    }

    h3 {
        color: #ffd700; /* Cor de ouro */
        font-size: 28px;
        margin-bottom: 10px;
    }

    h4 {
        color: #333;
        font-size: 18px;
        margin-top: 10px;
    }

    #img-camp {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin-top: 20px;
    }

    h6 {
        color: #ff0000; /* Cor vermelha para destacar */
        font-size: 18px;
        margin: 10px 0;
    }

    h5 {
        color: #333;
        font-size: 22px;
        margin: 10px 0;
        font-weight: bold;
        /*white-space: pre-line; /* Para lidar com as quebras de linha */
    }

    p {
        color: #888;

    }
    ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
        text-align: left;
    }

    li {
        padding-left: 20px;
        position: relative;
        margin-bottom: 10px;
    }

    li::before {
        content: '\2022'; /* Código do caractere para um ponto de lista (•) */
        color: #ffd700; /* Cor de ouro */
        font-size: 24px;
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        margin-right: 10px;
    }

    /* Ajuste tamanho dos botões */
    .celula-bilhete .numero-bilhete {
        width: 40px; /* Defina o tamanho desejado para os botões */
        height: 30px; /* Defina o tamanho desejado para os botões */
        padding: 5px;
        font-size: 14px;
        text-align: center;
        border-radius: 8px;
    }

        /* Adicionando estilos CSS */
        .tabela-bilhetes {
            border-collapse: collapse;
            width: 100%;
        }

        .tabela-bilhetes th,
        .tabela-bilhetes td {
            text-align: center;
        }

        .celula-bilhete {
            width: 5%;
        }

        .numero-bilhete {
            width: 100%; /* Largura de 100% dentro da célula */
            height: 20px;
            font-size: 10px;
            box-sizing: border-box;
        }

         /* Estilo botões navegação */

        #botoes-container {
        display: flex;
        justify-content: space-between;
        margin-top: 10px; /* Ajuste a margem conforme necessário */
        }

        #ver-menos-bilhetes, #ver-mais-bilhetes {
        background-color: #808080;
        border: 2px solid gray;
        color: white !important;
        font-weight: bold;
        width: 6vw;
        margin-bottom: 15%;
        height: 4vh;
        padding: 0.7%;
        margin: initial;

        text-align: center;
        line-height: normal; /* Opcional: ajuste a linha conforme necessário */

        }

        #ver-mais-bilhetes {
            margin-left: auto; /* Empurra o botão "Próximo" para a direita */
        }




        /* Cria Links diretos de navegação */
        .linha-paginas {
            display: flex;
            margin-bottom: 5px;
        }

        .pagina-link {
        margin-right: 2px;
        /* text-decoration: none; */
        color: #333;
        padding: 1px;
        padding-left: 1px;
        /* border: 1px solid #ccc; */
        /* border-radius: 3px; */

    }

        .pagina-link:hover {
            background-color: #f0f0f0;
        }

        .pagina-atual {
            background-color: #ddd;
        }

        #mostrar-mais-paginas {
        background-color: white;
        border: 2px solid white;
        color: black !important;
        font-weight: bold;
        width: 1vw;
        margin-bottom: 15%;
        height: 1vh;
        padding: 1.2%;
        font-size: 12px;
        }

        #mostrar-mais-paginas:hover {
            color: red;
            cursor: pointer;
            font-size: 14px;
        }

        /* Estilo aplicado ao clicar nas celulas para esoclher numeros da sorte */
        .celula-selecionada {
            background-color: #00ff00; /* Cor verde */
            color: #ffffff; /* Cor do texto branco para melhor contraste */
        }

        .celula-numero-escolhido {
        background-color: green;
        color: white;
        }



/* Para telas pequenas eté 767 pixels ///////////////////////////////////////////////*/
/* //////////////////////////////////////////////////////////////////////////////// */
    @media (max-width: 767px) {
        .conteudo-central {
            position: static;
            max-width: 100%;
            padding: 10px;
        }

        h3 {
            font-size: 24px;
        }

        h4 {
            font-size: 16px;
        }

        h6 {
            font-size: 16px;
        }

        h5 {
            font-size: 18px;
        }
    }
</style>

@endsection

<!-- Adicione isso à sua view -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    var pagina = 1;
    var bilhetesPorPagina = 100;
    var bilhetesCarregados = {};
    var numeroTotalDePaginas = Math.ceil({{ $rifa->quantidade_bilhetes }} / bilhetesPorPagina);
    var numerosSelecionados = [];
    var numerosEscolhidos = [];

     ////////////////////////INICIO////////////////////////////
     // Função para obter e exibir os números escolhidos do banco de dados
     function obterNumerosEscolhidos() {
        $.ajax({
            url: "{{ route('compradores.obter-numeros-escolhidos', ['id_campanha' =>  $rifa->id  ]) }}",
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                // Verifica se há números escolhidos e exibe na tela
                if (response.numerosEscolhidos.length > 0) {
                    numerosEscolhidos = response.numerosEscolhidos; // Atribui os números escolhidos à variável global
                    var numerosEscolhidosFormatados = numerosEscolhidos.join(', ');
                    $('#numeros-escolhidos').text('Números Escolhidos: ' + numerosEscolhidosFormatados);

                    // Adiciona ou atualiza um elemento na página com os números escolhidos
                    $('#div-numeros-escolhidos').html('<p>Números Escolhidos: ' + numerosEscolhidosFormatados + '</p>');
                } else {
                    $('#numeros-escolhidos').text('Nenhum número escolhido encontrado.');

                    // Remove ou esconde o elemento que exibe os números escolhidos
                    $('#div-numeros-escolhidos').empty();
                }
            },
            error: function (error) {
                console.error('Erro na requisição AJAX:', error);
            }
        });
    }
    // Chama a função para obter e exibir os números escolhidos
    obterNumerosEscolhidos();

    ////////////////////////FIM//////////////////////////////

    function carregarBilhetes(pagina) {
        $.ajax({
            url: '/rifas/{{ $rifa->id }}/bilhetes/' + pagina,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.bilhetes.length > 0) {
                    bilhetesCarregados[pagina] = response.bilhetes;
                    adicionarBilhetesNaTabela(response.bilhetes);
                } else {
                    $('#ver-mais-bilhetes').hide();
                }
            },
            error: function (error) {
                console.error('Erro na requisição AJAX:', error);
            }
        });
    }

    function carregarPagina(pagina) {
        if (!bilhetesCarregados[pagina]) {
            carregarBilhetes(pagina);
        }

        if (bilhetesCarregados[pagina]) {
            var bilhetesExibidos = bilhetesCarregados[pagina].slice(0, bilhetesPorPagina);
            adicionarBilhetesNaTabela(bilhetesExibidos);
            manterSelecaoCelulas();
            atualizarEstiloPaginaAtual();
        }
    }

// Função para adicionar bilhetes na tabela e mudar a cor dos botões correspondentes aos números escolhidos
function adicionarBilhetesNaTabela(bilhetes) {
    var tabela = $('#tabela-bilhetes tbody');
    tabela.empty();

    // Concatenar todos os números em uma única lista
    var todosNumerosEscolhidos = numerosEscolhidos.join(',').split(',');

    bilhetes.forEach(function (bilhete, index) {
        var numeroBilhete = (pagina - 1) * bilhetesPorPagina + index + 1;
        var numeroFormatado = numeroBilhete < 10 ? '0' + numeroBilhete : numeroBilhete.toString();

        if (numeroBilhete <= {{ $rifa->quantidade_bilhetes }}) {
            // Verifica se o número está entre os números escolhidos do banco de dados
            var corClasse = todosNumerosEscolhidos.some(function(numerosLista) {
                return numerosLista.split(',').includes(numeroFormatado);
            }) ? 'celula-numero-escolhido' : '';

            // Adiciona a célula com o botão na linha
            var botao = $('<button type="button" class="numero-bilhete ' + corClasse + '" name="bilhete" value="' + bilhete + '">' + numeroFormatado + '</button>');
            var celula = $('<td class="celula-bilhete"></td>').append(botao);

            // Adiciona a célula à tabela
            tabela.append(celula);

            // Adiciona uma nova linha após cada conjunto de 10 bilhetes ou ao final
            if ((index + 1) % 10 === 0 || (index + 1) === bilhetes.length) {
                tabela.append('<tr></tr>');  // Inicia uma nova linha
            }
        }
    });
    // Adicione a chamada à função que mantém a seleção das células
    manterSelecaoCelulas();
}

// Função para manter a seleção das células ao navegar nas páginas
function manterSelecaoCelulas() {
    // Restaurar as células selecionadas com a classe 'celula-selecionada'
    $('#tabela-bilhetes .numero-bilhete').each(function () {
        var numeroBilhete = $(this).text();

        if (numerosSelecionados.includes(numeroBilhete)) {
            $(this).addClass('celula-selecionada');
        } else {
            $(this).removeClass('celula-selecionada');
        }
    });
}
    
    function criarLinksPaginas() {
        if ( numeroTotalDePaginas > 1) {
            var paginasContainer = $('#paginas-container');
            paginasContainer.empty();

            var linksPorLinha = 10;
            var numeroDeLinhas = Math.ceil(numeroTotalDePaginas / linksPorLinha);

            for (var linha = 1; linha <= numeroDeLinhas; linha++) {
                var linhaContainer = $('<div class="linha-paginas" id="linha-' + linha + '"></div>');

                for (var i = 1; i <= linksPorLinha; i++) {
                    var numeroPagina = (linha - 1) * linksPorLinha + i;

                    if (numeroPagina <= numeroTotalDePaginas) {
                        var numeroFormatado = numeroPagina < 10 ? '0' + numeroPagina : numeroPagina;
                        var linkPagina = $('<a href="#" class="pagina-link link-navegacao" data-pagina="' + numeroPagina + '">' + numeroFormatado + '</a>');
                        linhaContainer.append(linkPagina);
                    }
                }

                paginasContainer.append(linhaContainer);
            }

            $('#mostrar-mais-paginas').toggle(numeroTotalDePaginas > 10);

            paginasContainer.on('click', '.pagina-link', function (event) {
                event.preventDefault();
                pagina = $(this).data('pagina');
                carregarPagina(pagina);
                atualizarEstiloPaginaAtual();
                manterSelecaoCelulas();
            });

            $('.linha-paginas:not(#linha-1) a').hide();
        }
    }

     function atualizarEstiloPaginaAtual() {
        $('.pagina-link').removeClass('pagina-atual');
        $('.pagina-link[data-pagina="' + pagina + '"]').addClass('pagina-atual');
    }

    // Adiciona evento de clique para o botão "Mostrar Mais"
    $('#mostrar-mais-paginas').on('click', function () {
        var linksPaginas = $('.linha-paginas:not(#linha-1) a');
        
        if (linksPaginas.is(':visible')) {
            linksPaginas.hide();
            $(this).find('i').removeClass('bi-caret-up-fill').addClass('bi-caret-down-fill');
        } else {
            linksPaginas.show();
            $(this).find('i').removeClass('bi-caret-down-fill').addClass('bi-caret-up-fill');
        }
    });

    $('#paginas-container').on('click', '.pagina-link', function (event) {
        event.preventDefault();
        pagina = $(this).data('pagina');
        carregarPagina(pagina);
        atualizarEstiloPaginaAtual();
        manterSelecaoCelulas();
    });

    $('#ver-mais-bilhetes').on('click', function () {
        pagina++;

        if (pagina <= numeroTotalDePaginas) {
            carregarPagina(pagina);

            if (pagina === numeroTotalDePaginas) {
                $('#ver-mais-bilhetes').hide();
            }

            $('#ver-menos-bilhetes').show();
            atualizarEstiloPaginaAtual();
        }
    });

    $('#ver-menos-bilhetes').on('click', function () {
        if (pagina > 1) {
            pagina--;
            carregarPagina(pagina);
            atualizarEstiloPaginaAtual();
        }

        if (pagina === 1) {
            $('#ver-menos-bilhetes').hide();
        }

        if (pagina < numeroTotalDePaginas) {
            $('#ver-mais-bilhetes').show();
        }
    });

    $('#ver-menos-bilhetes').hide();

    if (numeroTotalDePaginas <= 1) {
        $('#ver-mais-bilhetes, #mostrar-mais-paginas').hide();
    } else {
        $('#mostrar-mais-paginas').toggle(numeroTotalDePaginas > 10);
    }

    carregarPagina(pagina);
    criarLinksPaginas();
    atualizarEstiloPaginaAtual();
    manterSelecaoCelulas();


//////////////////////Inicio////////////////////////////
$('#tabela-bilhetes').on('click', '.numero-bilhete', function () {
    var numeroBilhete = $(this).text();

    // Verifica se o número clicado não está na lista de números escolhidos
    var todosNumerosEscolhidos2 = numerosEscolhidos.join(',').split(',');
    if (!todosNumerosEscolhidos2.includes(numeroBilhete)) {
        $(this).toggleClass('celula-selecionada');

        if ($(this).hasClass('celula-selecionada')) {
            numerosSelecionados.push(numeroBilhete);
        } else {
            numerosSelecionados = numerosSelecionados.filter(function (numero) {
                return numero !== numeroBilhete;
            });
        }

        console.log('Valor rifa : ',{{ $valorBilhetesForm }});
        // Recupera o valor dinâmico da view e formata como número
        var valorBilhetesForm = parseFloat("{{ $valorBilhetesForm }}");

        // Recalcula o valor a ser pago com base nos números selecionados e no valor dinâmico
        var valorASerPago = numerosSelecionados.length * valorBilhetesForm;

        $('#numeros-selecionados').text('Números selecionados: ' + numerosSelecionados.join(', '));
        $('#valor-a-ser-pago').text('Valor a ser pago: R$ ' + valorASerPago.toFixed(2)); // Formatando para exibir duas casas decimais
        localStorage.setItem('numerosSelecionados', JSON.stringify(numerosSelecionados));

        // Limpa a mensagem de aviso se houver uma
        $('#aviso-numero-escolhido').text('');
    } else {
        // Exibe uma mensagem de aviso na tela e no console
        var aviso = 'Número já escolhido. Não é possível selecionar novamente.';
        $('#aviso-numero-escolhido').text(aviso);
    }
});


//////////////////////fim////////////////////////////
//Passa valores da variavel numerosSelecionados e &rifaId={{ $rifa->id }} para a controller de outra view
    $(window).on('pageshow', function (event) {
        if (event.originalEvent.persisted) {
            var numerosSelecionadosArmazenados = localStorage.getItem('numerosSelecionados');
            if (numerosSelecionadosArmazenados) {
                numerosSelecionados = JSON.parse(numerosSelecionadosArmazenados);
            }

            $('#numeros-selecionados').text('Números selecionados: ' + numerosSelecionados.join(', '));
            manterSelecaoCelulas();
        }
    });

            // Adicione um evento de clique ao link
            $('#btn-cont').on('click', function (event) {
            // Evite o comportamento padrão do link para que o script possa executar antes da navegação
            event.preventDefault();

            // Obtém a URL da rota processar-bilhetes e adiciona os números selecionados
            var urlProcessarCompraBilhetes = "{{ route('compradores.processar-compra-bilhetes') }}?numerosSelecionados=" + JSON.stringify(numerosSelecionados) + "&rifaId={{ $rifa->id }}";

            // Redireciona para a rota processar-bilhetes
            window.location.href = urlProcessarCompraBilhetes;
        });
});

</script>




