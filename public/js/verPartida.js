import { creaNodo, obtenerPorcentaje } from "./utilidades.js";

/**
 * Archivos para mostrar la partida recreada en el perfil del jugador
 */

//Variables
var contendorBatalla = document.getElementsByClassName("batalla")[0];
var main = document.getElementsByTagName("main")[0];
let objeto = {
    cod_batalla: contendorBatalla.id,
};
const loadingMessage = document.getElementById("loading-message"); //div con el mensaje de cargar
//Petición para obtener los datos de partida una partida desde el historial
//ademas si hay respuesta del servidor se encarga del dibjo de la misma partida
loadingMessage.style.color="#ffb320"
loadingMessage.style.display = "block";
fetch("datosPartida", {
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
        juegoVisual(
            responseData.cod_registro_batalla_jugador,
            responseData.cod_registro_batalla_rival,
            responseData.inicialesJugador,
            responseData.inicialesRival
        );
    });

/**
 * Función que muestra de forma visual la partida obtniendo los datos del
 * servidor en función del turno actual de la partida 
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
    //Intervalo
    main.appendChild(
        creaNodo(
            "h2",
            "id=tituloCombate",
            "Combate",
            "class=text-center mb-3 mt-3",
            { color: "red", display: "none" }
        )
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
        fetch("http://www.starwarshunters.es/juego/muestra", {
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
                // console.log(responseData);
                // console.log(document.getElementById("vidaJugador"));
                loadingMessage.style.display = "none";
                document.getElementById("tituloCombate").style.display =
                    "block";
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
                        ? ""
                        : responseData.efectoJugador + "\n";
                document.getElementById("resumen-jugador").scrollTop =
                    document.getElementById("resumen-jugador").scrollHeight;
                document.getElementById("resumen-rival").innerHTML +=
                    responseData.efectoRival == undefined
                        ? ""
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

                    setTimeout(function () {
                        let div = creaNodo("div", "class=text-center mt-4");
                        let btn = creaNodo(
                            "a",
                            "href=" + location.href,
                            "class= btn btn-starwars",
                            "Volver a ver"
                        );
                        div.appendChild(btn);
                        main.appendChild(div);
                    }, 1000);
                }
            })
            .catch((err) => {
                // console.log(err);
            });
    }, 2000);
}
