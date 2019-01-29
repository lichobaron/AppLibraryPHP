function mostrarSalas(check) {
    var salas = document.getElementById("salas");
    var lugar = document.getElementById("lugar");
    salas.style.display = check.checked ? "block" : "none";
    lugar.style.display = check.checked ? "none" : "block";
}