
const total = 10;   
let actual = 1;    

const progresoFill  = document.querySelector("#progresoFill");
const progresoTexto = document.querySelector("#progresoTexto");
const progresoPorc  = document.querySelector("#progresoPorcentaje");
const btnAnterior   = document.querySelector("#btnAnterior");
const btnSiguiente  = document.querySelector("#btnSiguiente");

function hayRespuesta(numero) {
  const marcada = document.querySelector('input[name="pregunta' + numero + '"]:checked');
  if (marcada === null) {
    return false;
  }
  return true;
}
function mostrarPregunta(n) {
  for (let i = 1; i <= total; i++) {
    const bloque = document.querySelector("#pregunta-" + i);
    if (i === n) {
      bloque.classList.add("activa");
    } else {
      bloque.classList.remove("activa");
    }
  }

  const porcentaje = (n * 100) / total;
  progresoFill.style.width = porcentaje + "%";
  progresoTexto.textContent = "Pregunta " + n + " de " + total;
  progresoPorc.textContent = porcentaje + "%";

  if (n === 1) {
    btnAnterior.classList.add("disabled");
  } else {
    btnAnterior.classList.remove("disabled");
  }

  if (n === total) {
    btnSiguiente.textContent = "Ver resultado →";
  } else {
    btnSiguiente.textContent = "Siguiente →";
  }

  actualizarBotonSiguiente();
}

function actualizarBotonSiguiente() {
  if (hayRespuesta(actual)) {
    btnSiguiente.classList.remove("disabled");
  } else {
    btnSiguiente.classList.add("disabled");
  }
}

function seleccionar(numero, opcion) {
  document.querySelector("#op-" + numero + "-a").classList.remove("seleccionada");
  document.querySelector("#op-" + numero + "-b").classList.remove("seleccionada");
  document.querySelector("#op-" + numero + "-" + opcion).classList.add("seleccionada");
  actualizarBotonSiguiente();
}

for (let i = 1; i <= total; i++) {
  document.querySelector("#radio-" + i + "-a").addEventListener("click", () => {
    seleccionar(i, "a");
  });
  document.querySelector("#radio-" + i + "-b").addEventListener("click", () => {
    seleccionar(i, "b");
  });
}

function calcularResultado() {
  let contE = 0;
  let contS = 0;
  let contT = 0;
  let contJ = 0;

  for (let i = 1; i <= total; i++) {
    const marcada = document.querySelector('input[name="pregunta' + i + '"]:checked');
    if (marcada.value === "E") { contE = contE + 1; }
    if (marcada.value === "S") { contS = contS + 1; }
    if (marcada.value === "T") { contT = contT + 1; }
    if (marcada.value === "J") { contJ = contJ + 1; }
  }

  let codigo = "";

  if (contE >= 2) { codigo = codigo + "E"; } else { codigo = codigo + "I"; }
 
  if (contS >= 2) { codigo = codigo + "S"; } else { codigo = codigo + "N"; }
  
  if (contT >= 1) { codigo = codigo + "T"; } else { codigo = codigo + "F"; }
  
  if (contJ >= 1) { codigo = codigo + "J"; } else { codigo = codigo + "P"; }

  localStorage.setItem("sisvov_codigo", codigo);
  window.location.href = "resultado";
}

btnSiguiente.addEventListener("click", () => {
  if (hayRespuesta(actual) === false) {
    return; 
  }
  if (actual < total) {
    actual = actual + 1;
    mostrarPregunta(actual);
  } else {
    calcularResultado();
  }
});

btnAnterior.addEventListener("click", () => {
  if (actual > 1) {
    actual = actual - 1;
    mostrarPregunta(actual);
  }
});

mostrarPregunta(1);
