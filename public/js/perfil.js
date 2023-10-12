
/**
 * Archivo js para el perfil del jugador 
 */

//variables 
var editar = document.getElementById("editarDatos");
var elemetosUsuDisabled = document.querySelectorAll("[disabled].usuario");
var elementosHidden = document.querySelectorAll('[style="display:none"]');


//Determinar el tab actual 
$(document).ready(function () {
    var url = document.location.toString();
    if (url.match("#")) {
        $('.nav-tabs a[href="#' + url.split("#")[1] + '"]')[0].click();
    }
    setTimeout(function () {
        window.scrollTo(0, 0);
    }, 200);
});

// console.log({ elemetosUsuDisabled, elementosHidden });

//Habilitar la edicición del perfil del jugador
setInterval(function () {
    if (editar.classList.contains("cancelar")) {
        editar.addEventListener("click", (e) => {
            e.preventDefault();
            elemetosUsuDisabled.forEach((elemento) => {
                elemento.setAttribute("disabled", "");
            });
            document.getElementById("pass").style.display = "none";
            document.getElementById("confPass").style.display = "none";
            document.getElementById("divAvatar").style.display = "none";
            document.getElementById("updateUser").setAttribute("hidden", "");
            editar.classList.remove("cancelar");
        });
    } else {
        editar.addEventListener("click", (e) => {
            e.preventDefault();
            elemetosUsuDisabled.forEach((elemento) => {
                elemento.removeAttribute("disabled");
            });
            document.getElementById("pass").style.display = "block";
            document.getElementById("confPass").style.display = "block";
            document.getElementById("divAvatar").style.display = "block";
            document.getElementById("updateUser").removeAttribute("hidden");
            editar.classList.add("cancelar");
            editar.innerHTML = "Cancelar";

            editar.addEventListener("click", (e) => {
                e.preventDefault();
                elemetosUsuDisabled.forEach((elemento) => {
                    elemento.setAttribute("disabled", "");
                });
                document.getElementById("updateUser").setAttribute("hidden", "");
                editar.classList.remove("cancelar");
                editar.innerHTML = "Editar";
            });
        });
    }
}, 200);



