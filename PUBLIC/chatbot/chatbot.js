const SISVOV_BASE_URL = new URL('.', document.currentScript?.src || window.location.href);
const SISVOV_CHAT_ENDPOINT = new URL('api/chat.php', SISVOV_BASE_URL).href;
const SISVOV_REPORT_ENDPOINT = new URL('guardar_reporte.php', SISVOV_BASE_URL).href;

let chatHistory = [];
let chatSessionId = newSessionId();
let chatGeneration = 0;
let chatBusy = false;

function newSessionId() {
    if (typeof crypto !== 'undefined' && crypto.randomUUID) return crypto.randomUUID();
    return 'sisvov_' + Math.random().toString(36).slice(2) + Date.now().toString(36);
}

function appendMessage(text, sender) {
    const list = document.getElementById('messages-list');
    const message = document.createElement('div');
    message.className = `message-bubble ${sender} fade-in`;
    message.textContent = text;
    list.appendChild(message);
    const body = document.getElementById('chat-body');
    body.scrollTop = body.scrollHeight;
}

function showTyping(show) {
    document.getElementById('typing-indicator').classList.toggle('d-none', !show);
}

function setChatStatus(online) {
    const status = document.getElementById('chat-status-text');
    const dot = document.getElementById('chat-status-dot');
    if (status) status.textContent = online ? 'En línea' : 'Sin conexión';
    if (dot) {
        dot.classList.toggle('text-success', online);
        dot.classList.toggle('text-danger', !online);
    }
}

async function processUserInput() {
    if (chatBusy) return;
    const input = document.getElementById('user-input');
    const query = input.value.trim();
    if (!query) return;
    if (query.length > 500) {
        appendMessage('Tu consulta debe tener como máximo 500 caracteres.', 'bot');
        return;
    }
    const generation = chatGeneration;
    input.value = '';
    document.getElementById('user-bubble-text').textContent = query;
    document.getElementById('user-speech-bubble').classList.remove('opacity-0');
    appendMessage(query, 'user');
    chatBusy = true;
    document.getElementById('send-btn').disabled = true;
    showTyping(true);
    const previousHistory = chatHistory.slice(-6);
    chatHistory.push({ role: 'user', content: query });

    const controller = new AbortController();
    const timeout = setTimeout(() => controller.abort(), 33000);
    try {
        const response = await fetch(SISVOV_CHAT_ENDPOINT, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-SISVOV-CLIENT': 'web' },
            credentials: 'same-origin',
            signal: controller.signal,
            body: JSON.stringify({ message: query, session_id: chatSessionId, history: previousHistory }),
        });
        const data = await response.json();
        if (generation !== chatGeneration) return;
        if (!response.ok || data.status !== 'success') {
            throw new Error(data.message || 'No fue posible procesar tu consulta.');
        }
        const reply = String(data.reply || '').trim();
        if (!reply) throw new Error('n8n devolvió una respuesta vacía.');
        document.getElementById('robot-bubble-text').textContent = reply;
        appendMessage(reply, 'bot');
        chatHistory.push({ role: 'assistant', content: reply });
        chatHistory = chatHistory.slice(-12);
        setChatStatus(true);
    } catch (error) {
        if (generation !== chatGeneration) return;
        const message = error.name === 'AbortError'
            ? 'La consulta tardó demasiado. Verifica que n8n esté iniciado e inténtalo de nuevo.'
            : (error.message || 'No se pudo conectar con n8n.');
        appendMessage(message, 'bot');
        document.getElementById('robot-bubble-text').textContent = 'No pude conectarme al motor de respuestas.';
        setChatStatus(false);
    } finally {
        clearTimeout(timeout);
        if (generation === chatGeneration) {
            chatBusy = false;
            document.getElementById('send-btn').disabled = false;
            showTyping(false);
            input.focus();
        }
    }
}

function sendQuickMessage(text) {
    if (chatBusy) return;
    document.getElementById('chat-modal').classList.remove('hidden');
    document.getElementById('user-input').value = text;
    processUserInput();
}

function setupVoiceButton() {
    const voiceButton = document.getElementById('voice-btn');
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    if (!SpeechRecognition) {
        voiceButton.title = 'Reconocimiento de voz no disponible en este navegador';
        voiceButton.addEventListener('click', () => appendMessage('Tu navegador no admite el reconocimiento de voz. Puedes escribir tu pregunta.', 'bot'));
        return;
    }
    const recognition = new SpeechRecognition();
    recognition.lang = 'es-BO';
    recognition.interimResults = false;
    recognition.maxAlternatives = 1;
    voiceButton.addEventListener('click', () => {
        if (chatBusy) return;
        try { recognition.start(); } catch (_) { /* Podría estar escuchando */ }
    });
    recognition.addEventListener('start', () => voiceButton.classList.add('voice-listening'));
    recognition.addEventListener('end', () => voiceButton.classList.remove('voice-listening'));
    recognition.addEventListener('result', event => {
        const text = event.results[0][0].transcript;
        document.getElementById('user-input').value = text;
        processUserInput();
    });
    recognition.addEventListener('error', () => {
        appendMessage('No pude reconocer el audio. Revisa el permiso del micrófono o escribe tu pregunta.', 'bot');
    });
}

async function submitMaintenanceReport(event) {
    event.preventDefault();
    const form = event.currentTarget;
    const button = document.getElementById('btn-submit-report');
    const spinner = document.getElementById('submit-spinner');
    const alertBox = document.getElementById('form-alert');
    button.disabled = true;
    spinner.classList.remove('d-none');
    alertBox.classList.add('d-none');
    try {
        const response = await fetch(SISVOV_REPORT_ENDPOINT, {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type':'application/json', 'X-SISVOV-CLIENT':'web' },
            body: JSON.stringify({
                tipo: document.getElementById('report-type').value,
                email: document.getElementById('report-email').value.trim(),
                mensaje: document.getElementById('report-message').value.trim(),
            }),
        });
        const data = await response.json();
        if (!response.ok || data.status !== 'success') throw new Error(data.message || 'No se pudo enviar el reporte.');
        alertBox.className = 'alert alert-success mt-3';
        alertBox.textContent = `Reporte Nº ${data.id_reporte} guardado correctamente. Gracias por ayudarnos a mejorar SISVOV.`;
        form.reset();
    } catch (error) {
        alertBox.className = 'alert alert-danger mt-3';
        alertBox.textContent = error.message || 'No hay conexión con el buzón. Revisa que Apache y MySQL estén encendidos.';
    } finally {
        alertBox.classList.remove('d-none');
        button.disabled = false;
        spinner.classList.add('d-none');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('chat-modal');
    document.getElementById('chat-toggle-btn').addEventListener('click', () => modal.classList.toggle('hidden'));
    document.getElementById('close-chat-btn').addEventListener('click', () => modal.classList.add('hidden'));
    document.getElementById('clear-chat-btn').addEventListener('click', () => {
        chatGeneration++;
        chatSessionId = newSessionId();
        chatHistory = [];
        chatBusy = false;
        document.getElementById('send-btn').disabled = false;
        document.getElementById('messages-list').replaceChildren();
        document.getElementById('robot-bubble-text').textContent = '¡Hola! Conversación reiniciada. ¿En qué puedo ayudarte?';
        document.getElementById('user-bubble-text').textContent = '...';
        document.getElementById('user-speech-bubble').classList.add('opacity-0');
        showTyping(false);
        document.getElementById('user-input').focus();
    });
    document.getElementById('send-btn').addEventListener('click', processUserInput);
    document.getElementById('user-input').addEventListener('keydown', event => {
        if (event.key === 'Enter') { event.preventDefault(); processUserInput(); }
    });
    document.getElementById('maintenance-form').addEventListener('submit', submitMaintenanceReport);
    setupVoiceButton();
});
