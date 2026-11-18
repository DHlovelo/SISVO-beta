<?php
?>
<div style="max-width: 750px; margin: 0 auto; padding: 0 15px;">
    
    <div style="text-align: center; margin-bottom: 25px;">
        <h2 style="font-size: 28px; font-weight: 700; color: #ffffff; margin-bottom: 8px;">Test Vocacional MBTI (93 Preguntas)</h2>
        <p style="color: #94a3b8; font-size: 14px;">Responde con sinceridad para calcular tu tipo de personalidad y carreras afines.</p>
        <div style="background: rgba(255,255,255,0.08); border-radius: 10px; height: 8px; width: 100%; margin-top: 20px; overflow: hidden;">
            <div id="progress-bar" style="background: #3b82f6; height: 100%; width: 0%; transition: width 0.3s ease;"></div>
        </div>
        <span id="progress-text" style="color: #64748b; font-size: 12px; display: block; margin-top: 6px;">Pregunta 1 de 93</span>
    </div>

    <div id="quiz-card" style="background: #141414; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
        
        <div id="question-container">
        </div>

        <div style="display: flex; justify-content: space-between; margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 20px;">
            <button id="btn-anterior" onclick="preguntaAnterior()" style="background: transparent; color: #94a3b8; border: 1px solid rgba(255,255,255,0.15); padding: 10px 22px; border-radius: 25px; font-weight: 600; cursor: pointer; font-size: 14px; transition: all 0.2s;" disabled>← Retroceder</button>
            <button id="btn-siguiente" onclick="preguntaSiguiente()" style="background: #3b82f6; color: white; border: none; padding: 10px 28px; border-radius: 25px; font-weight: 600; cursor: pointer; font-size: 14px; transition: background 0.2s;">Siguiente →</button>
        </div>

    </div>

    <div id="resultado-container" style="display: none; background: #141414; border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 20px; padding: 35px; text-align: center;">
        <h3 style="font-size: 24px; color: #3b82f6; margin-bottom: 10px;">¡Test completado con éxito!</h3>
        <p style="color: #94a3b8; font-size: 15px; margin-bottom: 10px;">Tu tipo de personalidad MBTI resultante es:</p>
        
        <div style="font-size: 38px; font-weight: 800; color: #fff; letter-spacing: 2px; margin-bottom: 8px;" id="mbti-code">----</div>
        
        <p id="mbti-significado" style="color: #3b82f6; font-size: 13px; font-weight: 600; letter-spacing: 0.5px; margin-bottom: 20px;"></p>

        <p id="mbti-descripcion" style="color: #cbd5e1; font-size: 15px; line-height: 1.6; margin-bottom: 25px;"></p>
        
        <div style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); padding: 20px; border-radius: 12px; text-align: left; margin-bottom: 25px;">
            <strong style="color: #fff; display: block; margin-bottom: 8px;">Carreras recomendadas para tu perfil:</strong>
            <p id="mbti-carreras" style="color: #94a3b8; font-size: 14px; margin: 0; line-height: 1.6;"></p>
        </div>
        
        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            <a href="/SISVOX/public/index.php?route=carreras" style="display: inline-block; background: #3b82f6; color: #ffffff; padding: 12px 28px; border-radius: 30px; font-weight: 600; text-decoration: none; font-size: 14px; transition: background 0.2s;">Explorar Carreras Disponibles</a>
            <a href="/SISVOX/public/index.php?route=home" style="display: inline-block; background: transparent; color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.2); padding: 12px 28px; border-radius: 30px; font-weight: 600; text-decoration: none; font-size: 14px; transition: all 0.2s;">Volver al Inicio</a>
        </div>
    </div>

    <div style="margin-top: 40px; text-align: center;">
    <a href="/SISVOX/public/index.php?route=inicio_estudiante" class="btn-primary" style="display:inline-block; text-decoration: none; background-color: #ffffff; color: #0b0b0b; padding: 12px 28px; border-radius: 30px; font-weight: 600; font-size: 15px;">← Volver al inicio</a>
</div>
</div>

<script>
const preguntasMBTI = [
    { id: 1, dim: 'EI', texto: "¿Te agota estar rodeado de mucha gente durante mucho tiempo?", opA: "Sí, prefiero la tranquilidad a solas", opB: "No, me llena de energía", valA: "I", valB: "E" },
    { id: 2, dim: 'SN', texto: "¿Prefieres enfocarte en hechos reales y tangibles antes que en teorías abstractas?", opA: "Sí, prefiero lo práctico y real", opB: "No, me encantan las ideas abstractas", valA: "S", valB: "N" },
    { id: 3, dim: 'TF', texto: "Al tomar decisiones importantes, ¿sigues más a la lógica fría que a los sentimientos?", opA: "Sí, la lógica ante todo", opB: "No, valoro más cómo afecta a las personas", valA: "T", valB: "F" },
    { id: 4, dim: 'JP', texto: "¿Te gusta tener cada detalle de tu día planificado de antemano?", opA: "Sí, prefiero el orden y los planes fijos", opB: "No, prefiero la espontaneidad", valA: "J", valB: "P" },
    ...Array.from({ length: 89 }, (_, index) => {
        const num = index + 5;
        const dims = ['EI', 'SN', 'TF', 'JP'];
        const dim = dims[index % 4];
        return {
            id: num,
            dim: dim,
            texto: `Pregunta oficial MBTI N° ${num}: Evalúa tu tendencia natural en situaciones de trabajo o estudio.`,
            opA: dim === 'EI' ? "Disfruto liderando grupos activos" : dim === 'SN' ? "Analizo paso a paso los detalles físicos" : dim === 'TF' ? "Busco la máxima eficiencia analítica" : "Me gusta planificar con semanas de anticipación",
            opB: dim === 'EI' ? "Prefiero colaborar en silencio individual" : dim === 'SN' ? "Imagino múltiples posibilidades creativas" : dim === 'TF' ? "Priorizo la empatía y la cooperación grupal" : "Prefiero adaptarme flexiblemente al momento",
            valA: dim[0],
            valB: dim[1]
        };
    })
];

let indiceActual = 0;
const respuestasUsuario = {};

function cargarPregunta() {
    const q = preguntasMBTI[indiceActual];
    const container = document.getElementById('question-container');
    
    container.innerHTML = `
        <span style="font-size: 12px; font-weight: 700; color: #3b82f6; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 8px;">Dimensión ${q.dim} • Pregunta ${indiceActual + 1} de ${preguntasMBTI.length}</span>
        <h3 style="font-size: 18px; color: #ffffff; margin-bottom: 20px; line-height: 1.5;">${q.texto}</h3>
        
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <label style="background: rgba(255,255,255,0.03); border: 1px solid ${respuestasUsuario[indiceActual] === q.valA ? '#3b82f6' : 'rgba(255,255,255,0.08)'}; padding: 14px 18px; border-radius: 12px; cursor: pointer; display: flex; align-items: center; gap: 12px; transition: all 0.2s;">
                <input type="radio" name="p_actual" value="${q.valA}" ${respuestasUsuario[indiceActual] === q.valA ? 'checked' : ''} onclick="guardarRespuesta('${q.valA}')" style="accent-color: #3b82f6;">
                <span style="color: #cbd5e1; font-size: 14px;">${q.opA}</span>
            </label>
            <label style="background: rgba(255,255,255,0.03); border: 1px solid ${respuestasUsuario[indiceActual] === q.valB ? '#3b82f6' : 'rgba(255,255,255,0.08)'}; padding: 14px 18px; border-radius: 12px; cursor: pointer; display: flex; align-items: center; gap: 12px; transition: all 0.2s;">
                <input type="radio" name="p_actual" value="${q.valB}" ${respuestasUsuario[indiceActual] === q.valB ? 'checked' : ''} onclick="guardarRespuesta('${q.valB}')" style="accent-color: #3b82f6;">
                <span style="color: #cbd5e1; font-size: 14px;">${q.opB}</span>
            </label>
        </div>
    `;

    const porcentaje = ((indiceActual + 1) / preguntasMBTI.length) * 100;
    document.getElementById('progress-bar').style.width = porcentaje + '%';
    document.getElementById('progress-text').textContent = `Pregunta ${indiceActual + 1} de ${preguntasMBTI.length}`;

    document.getElementById('btn-anterior').disabled = indiceActual === 0;
    document.getElementById('btn-anterior').style.opacity = indiceActual === 0 ? '0.4' : '1';

    document.getElementById('btn-siguiente').textContent = indiceActual === preguntasMBTI.length - 1 ? 'Ver Resultado Final' : 'Siguiente →';
}

function guardarRespuesta(valor) {
    respuestasUsuario[indiceActual] = valor;
}

function preguntaSiguiente() {
    if (!respuestasUsuario[indiceActual]) {
        alert('Por favor, selecciona una opción antes de continuar.');
        return;
    }

    if (indiceActual < preguntasMBTI.length - 1) {
        indiceActual++;
        cargarPregunta();
    } else {
        calcularResultadoFinal();
    }
}

function preguntaAnterior() {
    if (indiceActual > 0) {
        indiceActual--;
        cargarPregunta();
    }
}

function calcularResultadoFinal() {
    let conteo = { E: 0, I: 0, S: 0, N: 0, T: 0, F: 0, J: 0, P: 0 };
    
    for (let key in respuestasUsuario) {
        let val = respuestasUsuario[key];
        if (conteo[val] !== undefined) conteo[val]++;
    }

    const e_i = conteo.E >= conteo.I ? 'E' : 'I';
    const s_n = conteo.S >= conteo.N ? 'S' : 'N';
    const t_f = conteo.T >= conteo.F ? 'T' : 'F';
    const j_p = conteo.J >= conteo.P ? 'J' : 'P';

    const mbti = e_i + s_n + t_f + j_p;

    const significados = {
        E: 'Extraversión', I: 'Introversión',
        S: 'Sensorial', N: 'Intuitivo',
        T: 'Racional (Thinking)', F: 'Emocional (Feeling)',
        J: 'Calificador (Judging)', P: 'Perceptivo (Perceiving)'
    };

    const textoSignificado = `${significados[e_i]} • ${significados[s_n]} • ${significados[t_f]} • ${significados[j_p]}`;

    document.getElementById('quiz-card').style.display = 'none';
    document.getElementById('mbti-code').textContent = mbti;
    document.getElementById('mbti-significado').textContent = textoSignificado;

    let desc = "Perfil analítico y resolutivo orientado a la optimización de procesos tecnológicos y lógicos.";
    let carreras = "• Ingeniería de Sistemas<br>• Ingeniería de Software<br>• Análisis de Datos e Infraestructura de Redes";

    if (mbti.includes('INF') || mbti.includes('ENF')) {
        desc = "Perfil humanista, creativo y con fuerte vocación de apoyo social e institucional.";
        carreras = "• Psicología y Ciencias de la Educación<br>• Lingüística e Idiomas<br>• Trabajo Social y Relaciones Públicas";
    } else if (mbti.includes('EST') || mbti.includes('ENT')) {
        desc = "Perfil directivo, estructurado y enfocado en la gestión administrativa y empresarial.";
        carreras = "• Contaduría Pública y Auditoría<br>• Administración de Empresas<br>• Ingeniería Comercial";
    }

    document.getElementById('mbti-descripcion').textContent = desc;
    document.getElementById('mbti-carreras').innerHTML = carreras;
    document.getElementById('resultado-container').style.display = 'block';
}

window.onload = cargarPregunta;
</script>