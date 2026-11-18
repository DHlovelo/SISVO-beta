const buscador      = document.querySelector("#buscadorInst");
const contador      = document.querySelector("#contadorInst");
const sinResultados = document.querySelector("#sinResultadosInst");
const botones       = document.querySelectorAll(".inst-filtro");
const tarjetas      = document.querySelectorAll(".inst-card");

let tipoActual = "todas";

function limpiar(texto) {
  return texto.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
}

function filtrar() {
  const busqueda = limpiar(buscador.value.trim());
  let visibles = 0;

  for (let i = 0; i < tarjetas.length; i++) {
    const tarjeta = tarjetas[i];
    const textoTarjeta = limpiar(tarjeta.getAttribute("data-texto"));
    const tipoTarjeta = tarjeta.getAttribute("data-tipo");

    const coincideTexto = textoTarjeta.includes(busqueda);
    const coincideTipo = (tipoActual === "todas") || (tipoTarjeta === tipoActual);

    if (coincideTexto && coincideTipo) {
      tarjeta.classList.remove("inst-oculta");
      visibles = visibles + 1;
    } else {
      tarjeta.classList.add("inst-oculta");
    }
  }

  contador.textContent = "Mostrando " + visibles + " de " + tarjetas.length + " instituciones";

  if (sinResultados !== null) {
    if (visibles === 0) {
      sinResultados.classList.remove("inst-oculta");
    } else {
      sinResultados.classList.add("inst-oculta");
    }
  }
}

buscador.addEventListener("input", filtrar);

for (let i = 0; i < botones.length; i++) {
  botones[i].addEventListener("click", () => {
    for (let j = 0; j < botones.length; j++) {
      botones[j].classList.remove("activo");
    }
    botones[i].classList.add("activo");
    tipoActual = botones[i].getAttribute("data-tipo");
    filtrar();
  });
}

filtrar();
