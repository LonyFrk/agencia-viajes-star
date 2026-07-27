"use strict";

/**
 * Retorna la fecha local en formato YYYY-MM-DD.
 */
function obtenerFechaActual() {
    const hoy = new Date();

    const anio = hoy.getFullYear();
    const mes = String(hoy.getMonth() + 1).padStart(2, "0");
    const dia = String(hoy.getDate()).padStart(2, "0");

    return `${anio}-${mes}-${dia}`;
}

/**
 * Validación del formulario de vuelos.
 */
function validarFormularioVuelo(evento) {
    const origen = document
        .getElementById("origen")
        .value
        .trim();

    const destino = document
        .getElementById("destino")
        .value
        .trim();

    const fecha = document
        .getElementById("fecha")
        .value;

    const plazas = Number(
        document.getElementById("plazas_disponibles").value
    );

    const precio = Number(
        document.getElementById("precio").value
    );

    if (origen === "" || destino === "") {
        alert("Debe ingresar el origen y el destino.");
        evento.preventDefault();
        return;
    }

    if (origen.toLowerCase() === destino.toLowerCase()) {
        alert(
            "La ciudad de origen y la ciudad de destino " +
            "deben ser diferentes."
        );

        evento.preventDefault();
        return;
    }

    if (fecha === "") {
        alert("Debe seleccionar la fecha del vuelo.");
        evento.preventDefault();
        return;
    }

    if (fecha < obtenerFechaActual()) {
        alert("La fecha del vuelo no puede estar en el pasado.");
        evento.preventDefault();
        return;
    }

    if (!Number.isInteger(plazas) || plazas <= 0) {
        alert(
            "Las plazas disponibles deben ser un número " +
            "entero mayor que cero."
        );

        evento.preventDefault();
        return;
    }

    if (!Number.isFinite(precio) || precio <= 0) {
        alert("El precio debe ser mayor que cero.");
        evento.preventDefault();
    }
}

/**
 * Validación del formulario de hoteles.
 */
function validarFormularioHotel(evento) {
    const nombre = document
        .getElementById("nombre_hotel")
        .value
        .trim();

    const ubicacion = document
        .getElementById("ubicacion")
        .value
        .trim();

    const habitaciones = Number(
        document
            .getElementById("habitaciones_disponibles")
            .value
    );

    const tarifa = Number(
        document.getElementById("tarifa_noche").value
    );

    if (nombre === "" || ubicacion === "") {
        alert(
            "Debe ingresar el nombre y la ubicación del hotel."
        );

        evento.preventDefault();
        return;
    }

    if (
        !Number.isInteger(habitaciones) ||
        habitaciones <= 0
    ) {
        alert(
            "Las habitaciones disponibles deben ser un " +
            "número entero mayor que cero."
        );

        evento.preventDefault();
        return;
    }

    if (!Number.isFinite(tarifa) || tarifa <= 0) {
        alert("La tarifa por noche debe ser mayor que cero.");
        evento.preventDefault();
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const fechaVuelo = document.getElementById("fecha");

    if (fechaVuelo) {
        fechaVuelo.min = obtenerFechaActual();
    }

    const formularioVuelo =
        document.getElementById("formularioVuelo");

    const formularioHotel =
        document.getElementById("formularioHotel");

    if (formularioVuelo) {
        formularioVuelo.addEventListener(
            "submit",
            validarFormularioVuelo
        );
    }

    if (formularioHotel) {
        formularioHotel.addEventListener(
            "submit",
            validarFormularioHotel
        );
    }
});