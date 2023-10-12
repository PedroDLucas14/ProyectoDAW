import {
    creaNodo,
    creaCarta,
    creaBarraVida,
    crearCollapse,
} from "./utilidades.js";

//Archivo js para controlar todos los eventos de botones, ocultaciones de los cruds
const sidebarToggle = document.body.querySelector("#sidebarToggle");
if (sidebarToggle) {
    sidebarToggle.addEventListener("click", (event) => {
        event.preventDefault();
        document.body.classList.toggle("sb-sidenav-toggled");
        localStorage.setItem(
            "sb|sidebar-toggle",
            document.body.classList.contains("sb-sidenav-toggled")
        );
    });
}
//Usuarios
var editarUsuario = document.getElementById("editarUsuario");
var elemetosUsuDisabled = document.querySelectorAll("[disabled].usuario");

if (editarUsuario != null && elemetosUsuDisabled != null) {
    //Si el usuario está en modo edición se activan las opciones del formulario y cambia su texto a cancelar
    setInterval(function () {
        if (editarUsuario.classList.contains("cancelar")) {
            editarUsuario.addEventListener("click", (e) => {
                e.preventDefault();
                elemetosUsuDisabled.forEach((elemento) => {
                    elemento.setAttribute("disabled", "");
                });
                document.getElementById("pass").style.display = "none";
                document.getElementById("confPass").style.display = "none";
                document.getElementById("divAvatar").style.display = "none";
                document
                    .getElementById("updateUser")
                    .setAttribute("hidden", "");
                editarUsuario.classList.remove("cancelar");
            });
        } else {
            editarUsuario.addEventListener("click", (e) => {
                e.preventDefault();
                elemetosUsuDisabled.forEach((elemento) => {
                    elemento.removeAttribute("disabled");
                });
                document.getElementById("pass").style.display = "block";
                document.getElementById("confPass").style.display = "block";
                document.getElementById("divAvatar").style.display = "block";
                document.getElementById("updateUser").removeAttribute("hidden");
                editarUsuario.classList.add("cancelar");
                editarUsuario.innerHTML = "Cancelar";

                editarUsuario.addEventListener("click", (e) => {
                    e.preventDefault();
                    elemetosUsuDisabled.forEach((elemento) => {
                        elemento.setAttribute("disabled", "");
                    });
                    editarUsuario.classList.remove("cancelar");
                    editarUsuario.innerHTML = "Editar";
                });
            });
        }
    }, 200);
}

//Naves
var editarNave = document.getElementById("editarNave");
var elemetosNaveDisabled = document.querySelectorAll("[disabled].nave");

if (editarNave != null && elemetosNaveDisabled != null) {
    //Si el usuario está en modo edición se activan las opciones del formulario y cambia su texto a cancelar
    setInterval(function () {
        if (editarNave.classList.contains("cancelar")) {
            editarNave.addEventListener("click", (e) => {
                e.preventDefault();
                elemetosNaveDisabled.forEach((elemento) => {
                    elemento.setAttribute("disabled", "");
                });
                document.getElementById("divImagen").style.display = "none";
                document
                    .getElementById("updateNave")
                    .setAttribute("hidden", "");
                editarNave.classList.remove("cancelar");
            });
        } else {
            editarNave.addEventListener("click", (e) => {
                e.preventDefault();
                elemetosNaveDisabled.forEach((elemento) => {
                    elemento.removeAttribute("disabled");
                });
                document.getElementById("divImagen").style.display = "block";
                document.getElementById("updateNave").removeAttribute("hidden");
                editarNave.classList.add("cancelar");
                editarNave.innerHTML = "Cancelar";
                editarNave.addEventListener("click", (e) => {
                    e.preventDefault();
                    elemetosNaveDisabled.forEach((elemento) => {
                        elemento.setAttribute("disabled", "");
                    });
                    editarNave.classList.remove("cancelar");
                    editarNave.innerHTML = "Editar";
                });
            });
        }
    }, 200);
}

//Pilotos
var editarPiloto = document.getElementById("editarPiloto");
var elemetosPilotoDisabled = document.querySelectorAll("[disabled].piloto");

if (editarPiloto != null && elemetosPilotoDisabled) {
    //Si el usuario está en modo edición se activan las opciones del formulario y cambia su texto a cancelar
    setInterval(function () {
        if (editarPiloto.classList.contains("cancelar")) {
            editarPiloto.addEventListener("click", (e) => {
                e.preventDefault();
                elemetosPilotoDisabled.forEach((elemento) => {
                    elemento.setAttribute("disabled", "");
                });
                document.getElementById("divImagen").style.display = "none";
                document
                    .getElementById("updatePiloto")
                    .setAttribute("hidden", "");
                editarPiloto.classList.remove("cancelar");
            });
        } else {
            editarPiloto.addEventListener("click", (e) => {
                e.preventDefault();
                elemetosPilotoDisabled.forEach((elemento) => {
                    elemento.removeAttribute("disabled");
                });
                document.getElementById("divImagen").style.display = "block";
                document
                    .getElementById("updatePiloto")
                    .removeAttribute("hidden");
                editarPiloto.classList.add("cancelar");
                editarPiloto.innerHTML = "Cancelar";
                editarPiloto.addEventListener("click", (e) => {
                    e.preventDefault();
                    elemetosPilotoDisabled.forEach((elemento) => {
                        elemento.setAttribute("disabled", "");
                    });
                    editarPiloto.classList.remove("cancelar");
                    editarPiloto.innerHTML = "Editar";
                });
            });
        }
    }, 200);
}

//Accesorios
var editarAccesorio = document.getElementById("editarAccesorio");
var elemetosAccesorioDisabled = document.querySelectorAll(
    "[disabled].accesorio"
);

if (editarAccesorio != null && elemetosAccesorioDisabled != null) {
    //Si el usuario está en modo edición se activan las opciones del formulario y cambia su texto a cancelar
    setInterval(function () {
        if (editarAccesorio.classList.contains("cancelar")) {
            editarAccesorio.addEventListener("click", (e) => {
                e.preventDefault();
                elemetosAccesorioDisabled.forEach((elemento) => {
                    elemento.setAttribute("disabled", "");
                });
                document.getElementById("divImagen").style.display = "none";
                document
                    .getElementById("updateAccesorio")
                    .setAttribute("hidden", "");
                editarAccesorio.classList.remove("cancelar");
            });
        } else {
            editarAccesorio.addEventListener("click", (e) => {
                e.preventDefault();
                elemetosAccesorioDisabled.forEach((elemento) => {
                    elemento.removeAttribute("disabled");
                });
                document.getElementById("divImagen").style.display = "block";
                document
                    .getElementById("updateAccesorio")
                    .removeAttribute("hidden");
                editarAccesorio.classList.add("cancelar");
                editarAccesorio.innerHTML = "Cancelar";
                editarAccesorio.addEventListener("click", (e) => {
                    e.preventDefault();
                    elemetosAccesorioDisabled.forEach((elemento) => {
                        elemento.setAttribute("disabled", "");
                    });
                    editarAccesorio.classList.remove("cancelar");
                    editarAccesorio.innerHTML = "Editar";
                });
            });
        }
    }, 200);
}

//Usuarios
//Control del borrado 
var borrarUsuario = document.querySelectorAll(".borrar");
var recuperar = document.querySelectorAll(".recuperar");

if (borrarUsuario != null) {
    borrarUsuario.forEach((element) => {
        element.addEventListener("click", function (e) {
            if (!confirm("¿Estas seguro que quieres borrar el usuario?")) {
                e.preventDefault();
            }
        });
    });
}
if (recuperar != null) {
    recuperar.forEach((element) => {
        element.addEventListener("click", function (e) {
            if (!confirm("¿Estas seguro que quieres recuperar el usuario?")) {
                e.preventDefault();
            }
        });
    });
}
