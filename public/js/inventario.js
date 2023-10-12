/**
 * Archivo js para controlar los eventos de la pagina del
 * inventario
 *
 */

/**
 * Variables
 */
const url = location.href.split("?")[0]; //link de la aplicacion
var btnMenosNaves = document.querySelectorAll(".menos-nave");
var btnMasNaves = document.querySelectorAll(".mas-nave");
var btnMenosPiloto = document.querySelectorAll(".menos-piloto");
var btnMasPiloto = document.querySelectorAll(".mas-piloto");
var btnMenosAccesorio = document.querySelectorAll(".menos-accesorio");
var btnMasAccesorio = document.querySelectorAll(".mas-accesorio");

//Control de la pestaña del tab actual
$(document).ready(function () {
    var url = document.location.toString();
    if (url.match("#")) {
        $('.nav-tabs a[href="#' + url.split("#")[1] + '"]')[0].click();
    }
    setTimeout(function () {
        window.scrollTo(0, 0);
    }, 200);
});

/**
 * Control de los eventos de los botones
 * relacionadas con las naves
 */

//Botón para el botón - y comprobar la reducción de nivel
btnMenosNaves.forEach((element) => {
    element.addEventListener("click", function (e) {
        e.preventDefault();
        let id = element.id.split("-")[1];
        let nivel =
            parseInt(document.getElementById("NaveNivel" + id).value) - 1;
        document.getElementById("NaveNivel" + id).value = nivel < 1 ? 1 : nivel;
        let objeto = { tipo: "nave", cod: id, subida: nivel < 1 ? 1 : nivel };
        fetch(url + "/compruebaSubida", {
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
                document.getElementById(
                    "costeNave" + id
                ).innerHTML = `Coste total de la mejora ${responseData.coste} creditos<br>
                    Nueva resistencia:${responseData.resistencia} puntos <br>
                    Nuevo ataque:${responseData.ataque} puntos <br>
                    Nueva defensa: ${responseData.defensa} puntos <br>`;
            })
            .catch((err) => {
                console.error("fetch error" + err);
            });
    });
});
//Botón para el botón + y comprobar la posible subida de nivel
btnMasNaves.forEach((element) => {
    element.addEventListener("click", function (e) {
        e.preventDefault();
        let id = element.id.split("+")[1];
        let nivel =
            parseInt(document.getElementById("NaveNivel" + id).value) + 1;
        document.getElementById("NaveNivel" + id).value = nivel;
        let objeto = { tipo: "nave", cod: id, subida: nivel };
        // console.log(url);
        fetch(url + "/compruebaSubida", {
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
                document.getElementById(
                    "costeNave" + id
                ).innerHTML = `Coste total de la mejora ${responseData.coste} creditos<br>
                    Nueva resistencia:${responseData.resistencia} puntos <br>
                    Nuevo ataque:${responseData.ataque} puntos <br>
                    Nueva defensa: ${responseData.defensa} puntos <br>`;
            })
            .catch((err) => {
                console.error("fetch error" + err);
            });
    });
});
//peticion para subir de nivel las naves
document.querySelectorAll(".btn-subiNivelNave").forEach((element) => {
    let id = element.id.split("NaveSubida")[1];
    element.addEventListener("click", function (e) {
        e.preventDefault();
        let nivel = document.getElementById("NaveNivel" + id).value;
        let aviso = confirm(
            `¿Seguro que quieres realizar la subida de ${nivel} niveles?`
        );
        if (aviso) {
            let objeto = {
                tipo: "nave",
                cod: id,
                niveles: nivel,
            };
            fetch(url + "/subidaNivel", {
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
                    if (responseData.mensaje) {
                        location.reload();
                    } else {
                        alert(responseData.error);
                    }
                });
        }
    });
});

/**
 * Pilotos
 */

//Botón para el botón - y comprobar la reducción de nivel
btnMenosPiloto.forEach((element) => {
    element.addEventListener("click", function (e) {
        e.preventDefault();
        let id = element.id.split("-")[1];
        let nivel =
            parseInt(document.getElementById("PilotoNivel" + id).value) - 1;
        document.getElementById("PilotoNivel" + id).value =
            nivel < 1 ? 1 : nivel;
        let objeto = { tipo: "piloto", cod: id, subida: nivel < 1 ? 1 : nivel };
        fetch(url + "/compruebaSubida", {
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
                document.getElementById(
                    "costePiloto" + id
                ).innerHTML = `Coste total de la mejora ${responseData.coste} creditos<br>
                    Nueva resistencia:${responseData.resistencia} puntos <br>
                    Nuevo ataque:${responseData.ataque} puntos <br>
                    Nueva defensa: ${responseData.defensa} puntos <br>`;
            })
            .catch((err) => {
                console.error("fetch error" + err);
            });
    });
});

//Botón para el botón + y comprobar la posible subida de nivel
btnMasPiloto.forEach((element) => {
    element.addEventListener("click", function (e) {
        e.preventDefault();
        let id = element.id.split("+")[1];
        let nivel =
            parseInt(document.getElementById("PilotoNivel" + id).value) + 1;
        document.getElementById("PilotoNivel" + id).value = nivel;
        let objeto = { tipo: "piloto", cod: id, subida: nivel };
        fetch(url + "/compruebaSubida", {
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
                document.getElementById(
                    "costePiloto" + id
                ).innerHTML = `Coste total de la mejora ${responseData.coste} creditos<br>
                    Nueva resistencia:${responseData.resistencia} puntos <br>
                    Nuevo ataque:${responseData.ataque} puntos <br>
                    Nueva defensa: ${responseData.defensa} puntos <br>`;
            })
            .catch((err) => {
                console.error("fetch error" + err);
            });
    });
});
//peticion para subir de nivel el piloto
document.querySelectorAll(".btn-subiNivelPiloto").forEach((element) => {
    let id = element.id.split("PilotoSubida")[1];
    element.addEventListener("click", function (e) {
        e.preventDefault();
        let nivel = document.getElementById("PilotoNivel" + id).value;
        let aviso = confirm(
            `¿Seguro que quieres realizar la subida de ${nivel} nivel/es?`
        );
        if (aviso) {
            let objeto = {
                tipo: "piloto",
                cod: id,
                niveles: nivel,
            };
            fetch(url + "/subidaNivel", {
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
                    if (responseData.mensaje) {
                        location.reload();
                    } else {
                        alert(responseData.error);
                    }
                });
        }
    });
});

/**
 * Accesorios
 */

//Botón para el botón - y comprobar la reducción de nivel
btnMenosAccesorio.forEach((element) => {
    element.addEventListener("click", function (e) {
        e.preventDefault();
        let id = element.id.split("-")[1];
        let nivel =
            parseInt(document.getElementById("AccesorioNivel" + id).value) - 1;
        document.getElementById("AccesorioNivel" + id).value =
            nivel < 1 ? 1 : nivel;
        let objeto = {
            tipo: "accesorio",
            cod: id,
            subida: nivel < 1 ? 1 : nivel,
        };
        fetch(url + "/compruebaSubida", {
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
                document.getElementById(
                    "costeAccesorio" + id
                ).innerHTML = `Coste total de la mejora ${responseData.coste} creditos<br>
                    Nueva resistencia:${responseData.resistencia} puntos <br>
                    Nuevo ataque:${responseData.ataque} puntos <br>
                    Nueva defensa: ${responseData.defensa} puntos <br>`;
            })
            .catch((err) => {
                console.error("fetch error" + err);
            });
    });
});
//Botón para el botón + y comprobar la posible subida de nivel
btnMasAccesorio.forEach((element) => {
    element.addEventListener("click", function (e) {
        e.preventDefault();
        let id = element.id.split("+")[1];
        let nivel =
            parseInt(document.getElementById("AccesorioNivel" + id).value) + 1;
        document.getElementById("AccesorioNivel" + id).value = nivel;
        let objeto = { tipo: "accesorio", cod: id, subida: nivel };
        fetch(url + "/compruebaSubida", {
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
                document.getElementById(
                    "costeAccesorio" + id
                ).innerHTML = `Coste total de la mejora ${responseData.coste} creditos<br>
                    Nueva resistencia:${responseData.resistencia} puntos <br>
                    Nuevo ataque:${responseData.ataque} puntos <br>
                    Nueva defensa: ${responseData.defensa} puntos <br>`;
            })
            .catch((err) => {
                console.error("fetch error" + err);
            });
    });
});

//peticion para subir de nivel el accesorios
document.querySelectorAll(".btn-subiNivelAccesorio").forEach((element) => {
    let id = element.id.split("AccesorioSubida")[1];
    element.addEventListener("click", function (e) {
        e.preventDefault();
        let nivel = document.getElementById("AccesorioNivel" + id).value;
        let aviso = confirm(
            `¿Seguro que quieres realizar la subida de ${nivel} nivel/es?`
        );
        if (aviso) {
            let objeto = {
                tipo: "accesorio",
                cod: id,
                niveles: nivel,
            };
            fetch(url + "/subidaNivel", {
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
                    console.log(responseData);
                    if (responseData.mensaje) {
                        location.reload();
                    } else {
                        alert(responseData.error);
                    }
                });
        }
    });
});
