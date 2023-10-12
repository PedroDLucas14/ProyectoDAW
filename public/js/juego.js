import {
    creaNodo,
    creaCarta,
    creaBarraVida,
    obtenerPorcentaje,
} from "./utilidades.js";
export { obtenerPorcentaje };

/**
 * variable globales
 */
var divAdversarios = document.querySelectorAll(".adversarios>div"); //Todos los divs que contiene la informacion de los rivales
var bRecargar = document.getElementById("recargar"); //Boton  de recargar
var main = document.getElementsByTagName("main")[0]; //main
const url = location.href; //link de la aplicacion
const loadingMessage = document.getElementById("loading-message"); //div con el mensaje de cargar
var eleccionJugaador = { nave: 0, numMax: 0, piloto: 0, accesorios: [] }; //Array con la eleccion del jugador
var modal = document.getElementById("staticBackdrop");

//Agregar onlicks a los div de los adversarios
agregarClicksDivs();

//EVento para el botón de recarga
bRecargar.addEventListener("click", function () {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // console.log(JSON.parse(xhr.responseText).respuesta);
                limpiarLista();
                recargarRivales(JSON.parse(xhr.responseText).respuesta);
            } else {
                console.error("Error en la solicitud:", xhr.status);
            }
        }
    };
    xhr.open("GET", url + "/recargar", true);
    xhr.send(null);
});

/**
 * Funcion para limpiar el div de adversarios
 */
function limpiarLista() {
    while (
        document.querySelector(".adversarios").hasChildNodes &&
        document.querySelector(".adversarios").firstChild.id != "recargar"
    ) {
        document.querySelector(".adversarios").firstChild.remove();
    }
}

/**
 * Función para agregar los clicks para los divs de los rivales
 */
function agregarClicksDivs() {
    for (const div of divAdversarios) {
        div.addEventListener("click", (e) => {
            e.preventDefault();
            let idRival = e.currentTarget.id;
            let objeto = {
                rival: idRival,
            };
            elegirRival(objeto);
        });
    }
}
/**
 * Función que recarga los rivales que puede ver el usuario en pantalla
 *
 * @param {*} rivales objeto con la informacón de los nuevos rivales
 */
function recargarRivales(rivales) {
    let nodo;
    for (const rival of rivales) {
        nodo = creaNodo("div", "id=" + rival.cod_usuario);
        nodo.appendChild(creaNodo("h4", `${rival.nick}`));
        nodo.appendChild(creaNodo("h5", `${rival.puntos} pts`));
        nodo.appendChild(creaNodo("img", "src=" + rival.division));
        document
            .querySelector(".adversarios")
            .insertBefore(nodo, document.getElementById("recargar"));
    }
    if (rivales.length == 0) {
        document
            .querySelector(".adversarios")
            .insertBefore(
                creaNodo("h2", "No hay rivales disponibles"),
                document.getElementById("recargar")
            );
    }
    divAdversarios = document.querySelectorAll(".adversarios>div");
    agregarClicksDivs();
}

/**
 * Función que manda los datos del rival al servidor
 * y devuelve los los objetos que posee el jugador activo
 * ademas limpia la lista de los jugadores para mostrar
 * los objetos que elegira el jugador.
 * @param {*} objeto
 */
function elegirRival(objeto) {
    fetch(url + "/iniciar", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify(objeto),
    })
        .then((response) => {
            return response.json();
        })
        .then((responseData) => {
            // console.log(responseData);
            //    location.href=responseData.url
            if (responseData) {
                document.querySelector("#tituloJuego").remove();
                document.querySelector(".adversarios").remove();
                document.querySelector("#infoTituloJuego ").remove();
            }
            muestraDatos(responseData);
        })
        .catch((err) => {
            // console.log("fetch error" + err);
        });
}

//-------------------------------------------------

//-------------------------------------------------
/**
 * Función que muestra la nave, piloto y accesorios del
 * jugador activo
 * La función muestra y ademas crea al botón para comenzar
 * el juego.
 * @param {*} responseData
 */
function muestraDatos(responseData) {
    //variables propias de la funcion

    let datosJugador = creaNodo("div", "class=datosJugador");
    let contenedorDatos = creaNodo("div", "class=cont-datos");
    let divAccesorios = creaNodo("div", "class=accesoriosJug");
    let divPilotos = creaNodo("div", "class=pilotosJug");
    let divNaves = creaNodo("div", "class=navesJug");
    let contenedorNaves = creaNodo("div", "id=contenedor-naves");
    let contenedorPilotos = creaNodo("div", "id=contenedor-pilotos");
    let contenedorAccesorios = creaNodo("div", "id=contenedor-accesorios");
    let eleccion = creaNodo("div", "class=cont-eleccion");
    let elecNavePiloto = creaNodo("div", "class=nav-piloto");
    let divPiloto = creaNodo("div", "class=piloto-elec");
    let divNave = creaNodo("div", "class=nave-elec");
    let elecAccesorios = creaNodo("div", "class=elec-acc mt-2");
    let aaa = creaNodo("div", "class=accElecc mb-3 row");
    let botones = creaNodo("div", "class=panel-start");
    let buton = creaNodo(
        "input",
        "type=submit",
        "class=btn btn-starwars mr-2 mt-2",
        "value=Comenzar",
        "name=comienza",
        "id=empezar"
    );
    let volver = creaNodo(
        "input",
        "type=buton",
        "class=btn btn-starwars mr-2 mt-2",
        "value=Cancelar Enfrentamiento",
        "name=volver",
        "id=volver"
    );
    contenedorNaves.appendChild(creaNodo("h5", "Naves:"));
    contenedorPilotos.appendChild(creaNodo("h5", "Pilotos:"));
    contenedorAccesorios.appendChild(creaNodo("h5", "Accesorios:"));

    //Agregar las naves de las que dispone el jugador
    for (const nave of responseData.jugador.naves) {
        let carta = creaCarta(
            "naves",
            nave.pivot.cod_usuario_nave + "nave",
            nave.imagen,
            nave.nombre,
            nave.descripcion,
            nave.pivot.resistencia_actual,
            nave.pivot.ataque_actual,
            nave.pivot.defensa_actual
        );
        //Añadir a la eleccion
        carta.addEventListener("click", (e) => {
            e.preventDefault();
            let idnave = e.currentTarget.id;
            let elemento = document.getElementById(idnave);
            if (elemento.classList.contains("select")) {
                document
                    .querySelectorAll(".naves.select")
                    .forEach((element) => {
                        element.classList.remove("select");
                    });
                eleccionJugaador.nave = 0;
                eleccionJugaador.numMax = 0;
                document.getElementById("limiteAcc").innerHTML =
                    "Limite de accesorios:" + eleccionJugaador.numMax;
                document.getElementById("imagenNave").setAttribute("src", "");
            } else {
                document
                    .querySelectorAll(".naves.select")
                    .forEach((element) => {
                        element.classList.remove("select");
                    });
                elemento.classList.add("select");
                eleccionJugaador.nave = parseInt(idnave);
                eleccionJugaador.numMax = nave.num_accesorios;
                document.getElementById("limiteAcc").innerHTML =
                    "Limite de accesorios:" + eleccionJugaador.numMax;
                document
                    .getElementById("imagenNave")
                    .setAttribute("src", nave.imagen);
            }
            // console.log(eleccionJugaador);
        });
        divNaves.appendChild(carta);
    }
    //Mostrar los pilotos de los que dispone el jugador
    for (const piloto of responseData.jugador.pilotos) {
        let carta = creaCarta(
            "piloto",
            piloto.pivot.cod_usuario_piloto + "piloto",
            piloto.imagen,
            piloto.nombre,
            piloto.descripcion,
            piloto.pivot.resistencia_actual,
            piloto.pivot.ataque_actual,
            piloto.pivot.defensa_actual
        );
        //Añadir a la eleccion
        carta.addEventListener("click", (e) => {
            e.preventDefault();
            let idpiloto = e.currentTarget.id;
            let elemento = document.getElementById(idpiloto);
            if (elemento.classList.contains("select")) {
                document
                    .querySelectorAll(".piloto.select")
                    .forEach((element) => {
                        element.classList.remove("select");
                    });
                eleccionJugaador.piloto = 0;
                document.getElementById("imagenPiloto").setAttribute("src", "");
            } else {
                document
                    .querySelectorAll(".piloto.select")
                    .forEach((element) => {
                        element.classList.remove("select");
                    });
                elemento.classList.add("select");
                eleccionJugaador.piloto = parseInt(idpiloto);
                document
                    .getElementById("imagenPiloto")
                    .setAttribute("src", piloto.imagen);
            }
            // console.log(eleccionJugaador);
        });
        divPilotos.appendChild(carta);
    }
    //Mostrar los accesorios de los que dispone el jugador
    for (const accesorio of responseData.jugador.accesorios) {
        let carta = creaCarta(
            "accesorio",
            accesorio.pivot.cod_usuario_accesorio + "acce",
            accesorio.imagen,
            accesorio.nombre,
            accesorio.descripcion,
            accesorio.pivot.resistencia_actual,
            accesorio.pivot.ataque_actual,
            accesorio.pivot.defensa_actual
        );
        carta.addEventListener("click", (e) => {
            e.preventDefault();
            let idAcce = e.currentTarget.id;
            let elemento = document.getElementById(idAcce);
            if (elemento.classList.contains("select")) {
                elemento.classList.remove("select");
                eleccionJugaador.accesorios.splice(
                    eleccionJugaador.accesorios.indexOf(idAcce)
                );
                document
                    .getElementById(
                        accesorio.pivot.cod_usuario_accesorio + "elec"
                    )
                    .remove();
                document.getElementById("numAccSelect").innerHTML =
                    "Número de accesorios: " +
                    eleccionJugaador.accesorios.length;
            } else {
                elemento.classList.add("select");
                eleccionJugaador.accesorios.push(parseInt(idAcce));
                document
                    .querySelector(".accElecc")
                    .appendChild(
                        creaNodo(
                            "img",
                            "src=" + accesorio.imagen,
                            "id=" +
                                accesorio.pivot.cod_usuario_accesorio +
                                "elec"
                        )
                    );
                document.getElementById("numAccSelect").innerHTML =
                    "Número de accesorios: " +
                    eleccionJugaador.accesorios.length;
            }
            // console.log(eleccionJugaador);
        });
        divAccesorios.appendChild(carta);
    }

    //Agregar los los conentedores
    contenedorNaves.appendChild(divNaves);
    contenedorDatos.appendChild(contenedorNaves);
    contenedorPilotos.appendChild(divPilotos);
    contenedorDatos.appendChild(contenedorPilotos);
    contenedorAccesorios.appendChild(divAccesorios);
    contenedorDatos.appendChild(contenedorAccesorios);
    contenedorDatos.appendChild(creaNodo("br"));

    divPiloto.appendChild(creaNodo("img", "id=imagenPiloto"));
    divNave.appendChild(creaNodo("img", "id=imagenNave"));

    elecNavePiloto.appendChild(divPiloto);
    elecNavePiloto.appendChild(divNave);
    eleccion.appendChild(elecNavePiloto);

    elecAccesorios.appendChild(aaa);
    elecAccesorios.appendChild(
        creaNodo(
            "label",
            "id=limiteAcc",
            "Limite de accesorios: " + eleccionJugaador.numMax
        )
    );
    elecAccesorios.appendChild(creaNodo("br"));
    elecAccesorios.appendChild(
        creaNodo(
            "label",
            "id=numAccSelect",
            "Número de accesorios: " + eleccionJugaador.accesorios.length
        )
    );
    eleccion.appendChild(elecAccesorios);

    botones.appendChild(buton);
    //Evento para el boton de comenzar
    buton.onclick = () => {
        //SI todo es valido para empezar la partida se llama a la funcion que la realiza sino se informa al usuario
        if (
            eleccionJugaador.nave != 0 &&
            eleccionJugaador.piloto != 0 &&
            eleccionJugaador.accesorios.length <= eleccionJugaador.numMax
        ) {
            loadingMessage.style.display = "block";
            comenzarBatalla(responseData.rival);
        } else {
            if (eleccionJugaador.accesorios.length > eleccionJugaador.numMax) {
                document.getElementById("mensaje-Modal").innerHTML =
                    '<i class="bi bi-exclamation-circle-fill" style="red"></i> Los accesorios no puede superar la capacidad de la nave';
            } else {
                document.getElementById("mensaje-Modal").innerHTML =
                    '<i class="bi bi-exclamation-circle-fill" style="red"></i> Debes de elegir un piloto y una nave';
            }
            var myModal = new bootstrap.Modal(
                document.getElementById("staticBackdrop"),
                {}
            );
            myModal.show();
        }
    };
    volver.onclick = (e) => {
        e.preventDefault();
        location.href = url;
    };
    botones.appendChild(volver);
    eleccion.appendChild(botones);
    //Añadir los datos del jugador y el de lo que va elegiendo el jugador
    datosJugador.appendChild(contenedorDatos);
    datosJugador.appendChild(eleccion);
    //Añadir las clases de boostrap necesarias
    main.classList.add(
        "d-flex",
        "justify-content-center",
        "align-items-center"
    );

    //añadir al main el div con los datos del jugador
    main.appendChild(datosJugador);
}

/**
 * Función que manda la peticion al sevidor con los datos
 * del rival junto a la eleccion del jugador
 * Si se produce respuesta de la peicion fetch se llama a la función que muestra el juego
 *
 * @param {*} codRIval
 */
function comenzarBatalla(codRIval) {
    // let elecionJugador = { nave: 12, piloto: 10, accesorios: [12] }
    let objeto = { datosJugador: eleccionJugaador, rival: codRIval };

    fetch(url + "/batalla", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify(objeto),
    })
        .then((response) => {
            return response.json();
        })
        .then((responseData) => {
            // console.log(responseData);
            setTimeout(
                lanzarJuego(
                    responseData.codUsuario,
                    responseData.rival,
                    responseData.cod_batalla
                ),
                2000
            );
            juegoVisual(
                responseData.cod_registro_batalla_jugador,
                responseData.cod_registro_batalla_rival,
                responseData.inicialesJugador,
                responseData.inicialesRival
            );
        })
        .catch((err) => {});
}

/**
 * Función que realiza la petición fetch que lanza el juego
 * con los datos necesarios para ello
 *
 * @param {*} cod_usuario
 * @param {*} cod_rival
 * @param {*} cod_batalla
 */
function lanzarJuego(cod_usuario, cod_rival, cod_batalla) {
    let objeto = {
        cod_usuario: cod_usuario,
        cod_rival: cod_rival,
        cod_batalla: cod_batalla,
    };
    fetch(url + "/hacer", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify(objeto),
    })
        .then((response) => {
            return response.json();
        })
        .then((responseData) => {
            // console.log(responseData.status);
        });
}
/**
 * Funcion que pide al servidor los datos de la batalla que se quiere visualizar
 * @param {*} cod_registro_batalla_jugador
 * @param {*} cod_registro_batalla_rival
 * @param {*} inicialesJugador
 * @param {*} inicialesRival
 */
function juegoVisual(
    cod_registro_batalla_jugador,
    cod_registro_batalla_rival,
    inicialesJugador,
    inicialesRival
) {
    var intervalo;
    let objeto = {
        cod_registro_batalla_jugador: cod_registro_batalla_jugador,
        cod_registro_batalla_rival: cod_registro_batalla_rival,
        primerTurno: true,
    };
    // console.log({ inicialesJugador, inicialesRival });
    loadingMessage.style.color = "red";
    main.classList.add("contendor-batalla");
    main.classList.remove(
        "d-flex",
        "justify-content-center",
        "align-items-center"
    );
    //Borrar el contenido del main y añadir la batalla para visualizar
    document.querySelector(".datosJugador").remove();
    let batalla = creaNodo("div", "class=batalla");
    let divJugador = creaNodo("div", "class=batalla-jugador");
    let divRival = creaNodo("div", "class=batalla-rival");
    divJugador.appendChild(creaNodo("h5", inicialesJugador.nombre));
    divJugador.appendChild(
        creaNodo(
            "img",
            "src=" + inicialesJugador.imagenNave,
            "alt=Nave-Jugador"
        )
    );
    divJugador.appendChild(
        creaBarraVida(
            inicialesJugador.resistencia,
            inicialesJugador.resistencia,
            "vidaJugador"
        )
    );
    divRival.appendChild(creaNodo("h5", inicialesRival.nombre));
    divRival.appendChild(
        creaNodo("img", "src=" + inicialesRival.imagenNave, "alt=Nave-rival")
    );
    divRival.appendChild(
        creaBarraVida(
            inicialesRival.resistencia,
            inicialesRival.resistencia,
            "vidaRival"
        )
    );
    batalla.appendChild(divJugador);
    batalla.appendChild(divRival);

    //Intervalo
    main.appendChild(batalla);
    main.appendChild(
        creaNodo("h2", "id=tlCombate", "Combate", "class=text-center mb-3", {
            color: "red",
            display: "none",
        })
    );
    let div = creaNodo("div", "id=resumen-batalla");
    div.appendChild(
        creaNodo("textarea", "id=resumen-jugador", "disabled=true", "rows=8")
    );
    div.appendChild(
        creaNodo("textarea", "id=resumen-rival", "disabled=true", "rows=8")
    );
    main.appendChild(div);

    intervalo = setInterval(() => {
        fetch(url + "/muestra", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify(objeto),
        })
            .then((response) => {
                return response.json();
            })
            .then((responseData) => {
                loadingMessage.style.display = "none";
                document.getElementById("tlCombate").style.display = "block";
                objeto.primerTurno = false;
                document
                    .getElementById("vidaJugador")
                    .setAttribute("aria-valuenow", responseData.vidaJugador);
                document.getElementById("vidaJugador").style.width =
                    obtenerPorcentaje(
                        responseData.vidaJugador,
                        inicialesJugador.resistencia
                    ) + "%";
                document
                    .getElementById("vidaRival")
                    .setAttribute("aria-valuenow", responseData.vidaRival);
                document.getElementById("vidaRival").style.width =
                    obtenerPorcentaje(
                        responseData.vidaRival,
                        inicialesRival.resistencia
                    ) + "%";
                document.getElementById("resumen-jugador").innerHTML +=
                    responseData.efectoJugador == undefined
                        ? "Fin de partida"
                        : responseData.efectoJugador + "\n";
                document.getElementById("resumen-jugador").scrollTop =
                    document.getElementById("resumen-jugador").scrollHeight;
                document.getElementById("resumen-rival").innerHTML +=
                    responseData.efectoRival == undefined
                        ? "Fin de partida"
                        : responseData.efectoRival + "\n";
                document.getElementById("resumen-rival").scrollTop =
                    document.getElementById("resumen-rival").scrollHeight;

                if (
                    responseData.estado == 0 ||
                    responseData.vidaJugador <= 0 ||
                    responseData.vidaRival <= 0 ||
                    responseData.turno == 90
                ) {
                    clearInterval(intervalo);
                    victoria(responseData.vidaRival);
                }
            })
            .catch((err) => {
            });
    }, 2000);
}

/**
 * Función para mostrar la pantalla de victoria o derrota
 * en función de la vida del rival
 * @param {*} vidaRival
 */
function victoria(vidaRival) {
    //Borrar el contenido del main
    while (main.firstChild) {
        main.removeChild(main.firstChild);
    }
    main.classList.remove("contendor-batalla");
    main.style.height = "100%";
    if (vidaRival == 0) {
        let div = creaNodo(
            "div",
            "id=finPartida",
            "class=d-flex flex-column align-items-center"
        );
        div.appendChild(creaNodo("img", "src=img/utilidades/victoria.png"));
        div.appendChild(
            creaNodo(
                "a",
                "href=" + location.href,
                "class= btn btn-starwars",
                "Volver a jugar"
            )
        );
        main.appendChild(div);
    } else {
        main.style.height = "100%";
        let div = creaNodo(
            "div",
            "id=finPartida",
            "class=d-flex flex-column align-items-center"
        );
        div.appendChild(creaNodo("img", "src=img/utilidades/derrota.png"));
        div.appendChild(
            creaNodo(
                "a",
                "href=" + location.href,
                "class= btn btn-starwars",
                "Volver a jugar"
            )
        );
        main.appendChild(div);
    }
}
