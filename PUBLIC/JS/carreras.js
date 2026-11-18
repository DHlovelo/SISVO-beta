const buscador      = document.querySelector("#buscadorCarreras");
const selectUni     = document.querySelector("#filtroUni");
const contador      = document.querySelector("#contadorCarreras");
const sinResultados = document.querySelector("#sinResultadosCarreras");
const botones       = document.querySelectorAll(".carr-filtro");
const tarjetas      = document.querySelectorAll(".carr-card");

let gradoActual = "todos";

function limpiar(texto) {
  return texto.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
}

function filtrar() {
  const busqueda = limpiar(buscador.value.trim());
  const uniElegida = selectUni.value;          // "0" = todas
  let visibles = 0;

  for (let i = 0; i < tarjetas.length; i++) {
    const tarjeta = tarjetas[i];
    const filas = tarjeta.querySelectorAll(".carr-oferta");
    let filasVisibles = 0;

    for (let j = 0; j < filas.length; j++) {
      const coincideUni = (uniElegida === "0") || (filas[j].getAttribute("data-uni") === uniElegida);
      const coincideGrado = (gradoActual === "todos") || (filas[j].getAttribute("data-grado") === gradoActual);

      if (coincideUni && coincideGrado) {
        filas[j].classList.remove("carr-oculta");
        filasVisibles = filasVisibles + 1;
      } else {
        filas[j].classList.add("carr-oculta");
      }
    }

    const coincideTexto = limpiar(tarjeta.getAttribute("data-texto")).includes(busqueda);

    if (filasVisibles > 0 && coincideTexto) {
      tarjeta.classList.remove("carr-oculta");
      visibles = visibles + 1;
    } else {
      tarjeta.classList.add("carr-oculta");
    }
  }

  contador.textContent = "Mostrando " + visibles + " de " + tarjetas.length + " carreras";

  if (sinResultados !== null) {
    if (visibles === 0) {
      sinResultados.classList.remove("carr-oculta");
    } else {
      sinResultados.classList.add("carr-oculta");
    }
  }
}

buscador.addEventListener("input", filtrar);
selectUni.addEventListener("change", filtrar);

for (let i = 0; i < botones.length; i++) {
  botones[i].addEventListener("click", () => {
    for (let j = 0; j < botones.length; j++) {
      botones[j].classList.remove("activo");
    }
    botones[i].classList.add("activo");
    gradoActual = botones[i].getAttribute("data-grado");
    filtrar();
  });
}

filtrar();  
