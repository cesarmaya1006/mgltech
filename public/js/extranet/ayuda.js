window.addEventListener('DOMContentLoaded', function () {
    let titulos = document.querySelectorAll('.ayudas .titulo') 
    titulos.forEach(titulo => {
        titulo.addEventListener('click', desplegable)
    }) 
    
    function desplegable(titulo){
        let tituloBloque = titulo.target
        let contenidos = tituloBloque.parentElement.querySelectorAll('.bloque-contenido')
        let contenidoBloque = tituloBloque.nextElementSibling

        if(contenidoBloque.classList.contains('d-none')){
            contenidos.forEach(contenido => {
                if(!contenido.classList.contains('d-none')){
                    contenido.classList.add('d-none')
                }
            })
            contenidoBloque.classList.remove('d-none')
        }else{
            contenidoBloque.classList.add('d-none')
        }
    }
})