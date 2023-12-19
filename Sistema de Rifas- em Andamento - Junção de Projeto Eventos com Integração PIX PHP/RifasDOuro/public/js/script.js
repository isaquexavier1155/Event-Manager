var menuItem = document.querySelectorAll('.item-menu')

function selectLink(){
    menuItem.forEach((item)=>
        item.classList.remove('ativo')
    )
    this.classList.add('ativo')
}

menuItem.forEach((item)=>
    item.addEventListener('click', selectLink)
)


// Efeito de expansão de Menu Lateral em todas as páginas versão Mobile
var btnExp = document.querySelector('#btn-exp')
var menuSide = document.querySelector('.menu-lateral')

btnExp.addEventListener('click', function(){
    menuSide.classList.toggle('expandir')
})

document.addEventListener('DOMContentLoaded', function () {
    const btnExpandir = document.getElementById('btn-exp');
    const content = document.querySelector('.content');

    btnExpandir.addEventListener('click', function () {
        document.body.classList.toggle('menu-expandido');
    });
});


