export {
    creaNodo,
    creaCarta,
    creaBarraVida,
    crearCollapse,
    crearTab,
    obtenerPorcentaje,
};

/**
 * Clase de utilidades varias que se usan en la aplicacción
 *
 */

/**
 * Función creaNodo
 *
 * @param string tipo: Tipo de elemento HTML que se va a crear.
 * @param (array) restoParams: Atributos que se a asignar al elemento.
 *
 * Cada atributo se pasará como parámetro de la siguiente forma: "atributo=valor".
 *
 * Se puede pasar un array asociativo con los estilos que se van a aplicar al nodo.
 * Cabe destacar que las propiedades CSS o claves de dicho objeto deben declararse como
 * se haría en CSS, y NO como en JS.
 *
 * Ejm->CreaNodo("p","Hola mundo","id=principal",{backgraund:"red"})
 */

function creaNodo(tipo, ...restoParams) {
    let nodo = document.createElement(tipo);

    for (let atributo of restoParams) {
        if (typeof atributo == "object") {
            for (let estilo in atributo) {
                nodo.style.setProperty(estilo, atributo[estilo]);
            }
        } else {
            let atribValor = atributo.split("=");
            if (atribValor.length != 1) {
                nodo.setAttribute(atribValor[0], atribValor[1]);
            } else {
                let nodeText = document.createTextNode(atribValor[0]);
                nodo.appendChild(nodeText);
            }
        }
    }

    return nodo;
}

/**
 * Función que crea una card de boostrap
 *
 * @param {string} tipo ->clase asociada ej(piloto,nave etc )
 * @param {*} id ->id: que tendra el id
 * @param {string} src ->ruta de la imagen del card body
 * @param {string} titulo ->titulo de la carta
 * @param {string|null} descripcion  ->descripcioón de la carta en forma
 *  de parrafo puede nulo
 * @param {*} resistencia ->resistencia de la carta
 * @param {*} ataque ->ataque de la carta
 * @param {*} defensa ->defensa de la carta
 * @returns
 */
function creaCarta(
    tipo,
    id,
    src,
    titulo,
    descripcion = null,
    resistencia,
    ataque,
    defensa
) {
    let carta = creaNodo("div", "class=card " + tipo, "id=" + id);
    carta.appendChild(
        creaNodo("img", "src=" + src, "class=card-img-top", "alt=card" + tipo, {
            width: "20rem",
        })
    );
    let cardBody = creaNodo("div", "class=card-body oculto");
    cardBody.appendChild(creaNodo("h5", "class=card-title", titulo));
    if (descripcion != null) {
        cardBody.appendChild(creaNodo("p", descripcion));
    }
    carta.appendChild(cardBody);

    //lista
    let lista = creaNodo("ul", "class=list-group list-group-flush oculto");
    lista.appendChild(
        creaNodo(
            "li",
            "class=list-group-item",
            "Resistencia : " +
                (resistencia == null
                    ? (resistencia = "-")
                    : (resistencia = resistencia))
        )
    );
    lista.appendChild(
        creaNodo(
            "li",
            "class=list-group-item",
            "Ataque :" + (ataque == null ? (ataque = "-") : (ataque = ataque))
        )
    );
    lista.appendChild(
        creaNodo(
            "li",
            "class=list-group-item",
            "Defensa : " +
                (defensa == null ? (defensa = "-") : (defensa = defensa))
        )
    );

    carta.appendChild(lista);

    return carta;
}
/**
 * Función que permite crear las barras de
 * vida que contendra el juego
 *
 * @param {*} valorActual ->valor actual del progrees
 * @param {*} ValorMax ->valor max del progress
 * @param {*} id ->id del progress
 * @returns
 */
function creaBarraVida(valorActual, ValorMax, id) {
    let progress = creaNodo("div", "class=progress");
    let barra = creaNodo(
        "div",
        "id=" + id,
        "class=progress-bar bg-success",
        "role=progressbar",
        "aria-valuenow=" + valorActual,
        "aria-valuemin=0",
        "aria-valuemax=" + ValorMax
    );
    barra.style.width = "100%";
    barra.style.height = "20px";
    progress.appendChild(barra);

    return progress;
}

/**
 * Función que permite la creacion de
 * un element collapse asociada a un componente
 * @param {*} id
 * @param {*} componente
 * @returns
 */
function crearCollapse(id, componente) {
    let div = creaNodo("div", "class=collapse", "id=" + id);
    div.appendChild(componente);

    return div;
}

/**
 * Funcion que crea tabs con las opciones pasadas por parametros
 *
 * @param {*} opciones
 * @returns
 */
function crearTab(opciones) {
    //Contenedor
    let div = creaNodo("div", "class=tabs");
    let lista = creaNodo("ul", "class=nav nav-tabs");
    let primero = true;

    //Opciones del tab
    for (const opcion of opciones) {
        let li = creaNodo("li", "class=nav-item");
        if (primero) {
            li.appendChild(
                creaNodo(
                    "a",
                    "class=nav-link active",
                    "id=nav-" + opcion.nombre + "-tab",
                    "data-toggle=tab",
                    "href=#" + opcion.nombre,
                    opcion.nombre
                )
            );
        } else {
            li.appendChild(
                creaNodo(
                    "a",
                    "class=nav-link",
                    "id=nav-" + opcion.nombre + "-tab",
                    "data-toggle=tab",
                    "href=#" + opcion.nombre,
                    opcion.nombre
                )
            );
        }
        lista.appendChild(li);
        primero = false;
    }
    div.appendChild(lista);
    //tab conenten
    let content = creaNodo("div", "class=tab-content");
    primero = true;
    for (const opcion of opciones) {
        let tabPanel;
        if (primero) {
            tabPanel = creaNodo(
                "div",
                "class=tab-pane fade show active",
                "id=" + opcion.nombre
            );
        } else {
            tabPanel = creaNodo(
                "div",
                "class=tab-pane fade",
                "id=" + opcion.nombre
            );
        }
        for (const dato of opcion.datos) {
            let contenedorInd = creaNodo("div", "id=");
            contenedorInd.appendChild(creaNodo("h6", dato.nombre));
            contenedorInd.appendChild(creaNodo("img", "src=" + dato.imagen));
            tabPanel.appendChild(contenedorInd);
        }
        primero = false;
        content.appendChild(tabPanel);
    }

    //añadir el contenido al div
    div.appendChild(content);

    return div;
}

/**
 * Onteiene el valor en porcentaje de un numero en relacion a otro máximo
 * @param {*} num
 * @param {*} max
 * @returns
 */
function obtenerPorcentaje(num, max) {
    return Math.floor((num * 100) / max);
}
