/**
 * Js para controlar los eventos de las paginas del mercado
 *
 */

/**
 * JQuery para controlar el tab activo
 */

$(document).ready(function () {
    var url = document.location.toString();
    if (url.match("#")) {
        $('.nav-tabs a[href="#' + url.split("#")[1] + '"]')[0].click();
    }
    setTimeout(function () {
        window.scrollTo(0, 0);
    }, 200);
});

//Evento del boton comprar
try {
    document.querySelectorAll(".btn-compras-naves").forEach(element=>{
        element.addEventListener('click',function(e){
            e.preventDefault()
            let aviso=confirm("¿Estas seguro que quieres comprar la nave?")
            if(aviso){
                window.location.href = e.target.href;
            }else{
                alert('Compra cancelada')
            }
        })
    })
    document.querySelectorAll(".btn-compras-piloto").forEach(element=>{
        element.addEventListener('click',function(e){
            e.preventDefault()
            let aviso=confirm("¿Estas seguro que quieres comprar el piloto?")
            if(aviso){
                window.location.href = e.target.href;
            }else{
                alert('Compra cancelada')
            }
        })
    })
    document.querySelectorAll(".btn-compras-acc").forEach(element=>{
        element.addEventListener('click',function(e){
            e.preventDefault()
            let aviso=confirm("¿Estas seguro que quieres comprar el accesorio?")
            if(aviso){
                window.location.href = e.target.href;
            }else{
                alert('Compra cancelada')
            }
        })
    })
} catch (error) {

}

