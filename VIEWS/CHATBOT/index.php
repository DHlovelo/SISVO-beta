<?php
// views/chatbot/index.php
?>
<!-- Cargar la hoja de estilos específica del chatbot -->
<link rel="stylesheet" href="/SISVOX/public/css/chatbot.css?v=<?php echo time(); ?>">

<div style="max-width: 850px; margin: 20px auto; padding: 0 15px;">
    <div class="chat-card">
        
        <!-- Cabecera del Chat -->
        <div class="chat-header">
            <div class="bot-avatar">🤖</div>
            <div>
                <h1 style="font-size: 1.25rem; margin: 0; color: #fff;">Asistente Virtual SISVO</h1>
                <p style="margin: 2px 0 0 0;">Orientación sobre el sistema, carreras, instituciones y becas</p>
            </div>
            <div class="online-dot" title="En línea"></div>
        </div>

        <!-- Cuerpo / Mensajes del Chat -->
        <div class="chat-body" id="chat-messages">
            <div class="message-row bot-row">
                <div class="message bot-message">
                    <div class="message-label">Asistente SISVO</div>
                    <p>Hola 👋 Soy VOX, el asistente virtual de SISVO. Puedes preguntarme de diferentes maneras sobre el test vocacional, universidades e institutos, becas o sobre cómo funciona la plataforma.</p>
                </div>
            </div>
        </div>

        <!-- Preguntas Rápidas -->
        <div class="quick-questions">
            <button class="quick-btn" onclick="enviarSugerencia('Test vocacional')">Test vocacional</button>
            <button class="quick-btn" onclick="enviarSugerencia('Universidades')">Universidades</button>
            <button class="quick-btn" onclick="enviarSugerencia('Becas')">Becas</button>
            <button class="quick-btn" onclick="enviarSugerencia('¿Para qué sirves?')">¿Para qué sirves?</button>
        </div>

        <!-- Área de Entrada de Mensaje -->
        <div class="chat-input-area">
            <input type="text" id="user-input" placeholder="Escribe tu pregunta" style="flex: 1;" onkeypress="if(event.key === 'Enter') enviarMensaje();">
            <button class="send-btn" onclick="enviarMensaje()">Enviar</button>
        </div>

        <!-- parte de abajo del Chat -->
        <div class="chat-footer" style="padding-top: 10px;">
            VOX - Asistente Inteligente
        </div>

    </div>
    <div style="margin-top: 40px; text-align: center;">
    <a href="/SISVOX/public/index.php?route=inicio_estudiante" class="btn-primary" style="display:inline-block; text-decoration: none; background-color: #ffffff; color: #0b0b0b; padding: 12px 28px; border-radius: 30px; font-weight: 600; font-size: 15px;">← Volver al inicio</a>
</div>
</div>

<script>
function enviarSugerencia(texto) {
    document.getElementById('user-input').value = texto;
    enviarMensaje();
}

function enviarMensaje() {
    const input = document.getElementById('user-input');
    const mensaje = input.value.trim();
    if (!mensaje) return;

    const chatMessages = document.getElementById('chat-messages');

    // Fila del mensaje del usuario
    const userRow = document.createElement('div');
    userRow.className = 'message-row user-row';
    userRow.innerHTML = `
        <div class="message user-message">
            <div class="message-label" style="text-align: right;">Tú</div>
            <p>${escapeHtml(mensaje)}</p>
        </div>
    `;
    chatMessages.appendChild(userRow);

    input.value = '';
    chatMessages.scrollTop = chatMessages.scrollHeight;

    // Mostrar animación de "escribiendo..."
    const typingRow = document.createElement('div');
    typingRow.className = 'message-row bot-row';
    typingRow.id = 'typing-indicator';
    typingRow.innerHTML = `
        <div class="message bot-message">
            <div class="message-label">Asistente SISVO</div>
            <div class="typing">
                <span></span><span></span><span></span>
            </div>
        </div>
    `;
    chatMessages.appendChild(typingRow);
    chatMessages.scrollTop = chatMessages.scrollHeight;

    // Simular respuesta del bot tras un breve retraso
    setTimeout(() => {
        document.getElementById('typing-indicator').remove();

        let respuesta = "Entiendo tu consulta sobre " + mensaje.toLowerCase() + ". SISVO te ayuda a conectar con las mejores opciones académicas.";
        const msgLower = mensaje.toLowerCase();

        if (msgLower.includes('becas')) {
            respuesta = "Contamos con una sección dedicada a becas institucionales y estatales con todos sus requisitos detallados. Puedes consultarlas desde el menú superior en la sección 'Becas'.";
        } else if (msgLower.includes('test')) {
            respuesta = "El test vocacional consta de preguntas rápidas diseñadas para evaluar tu perfil y orientarte hacia las carreras de ingeniería y tecnología más afines.";
        } else if (msgLower.includes('universidades') || msgLower.includes('instituciones')) {
            respuesta = "Puedes explorar nuestro directorio completo de universidades e institutos aliados en la sección 'Instituciones'.";
        } else if (msgLower.includes('sirves')) {
            respuesta = "Sirvo para guiarte en tu orientación vocacional, mostrarte becas disponibles, instituciones y resolver tus dudas sobre la plataforma SISVO.";
        }

        const botRow = document.createElement('div');
        botRow.className = 'message-row bot-row';
        botRow.innerHTML = `
            <div class="message bot-message">
                <div class="message-label">Asistente SISVO</div>
                <p>${respuesta}</p>
            </div>
        `;
        chatMessages.appendChild(botRow);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }, 1000);
}

function escapeHtml(text) {
    const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}
</script>