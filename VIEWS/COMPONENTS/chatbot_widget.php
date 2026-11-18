 <button id="chat-toggle-btn" class="btn btn-primary rounded-circle shadow-lg">
            <i class="bi bi-robot fs-3"></i>
    </button>

    <button id="maintenance-toggle-btn" class="btn btn-warning rounded-circle shadow" data-bs-toggle="modal" data-bs-target="#maintenanceModal" title="Buzón de Mantenimiento / Reportes">
            <i class="bi bi-wrench-adjustable-circle-fill fs-4"></i>
    </button>

    <div id="chat-modal" class="chat-container shadow-lg hidden">
        <!-- Header -->
        <div class="chat-header d-flex align-items-center justify-content-between p-3 bg-gradient-purple text-white">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-cpu-fill fs-4 text-info"></i>
                <div>
                    <h6 class="m-0 fw-bold">SISVOV Assistant</h6>
                    <small class="text-light opacity-75"><i id="chat-status-dot" class="bi bi-circle-fill text-success micro-dot"></i> <span id="chat-status-text">En línea</span></small>
                </div>
            </div>
            <div>
                <button id="clear-chat-btn" class="btn btn-sm btn-outline-light me-1" title="Reiniciar Chat"><i class="bi bi-trash"></i></button>
                <button id="close-chat-btn" class="btn btn-sm btn-outline-light"><i class="bi bi-x-lg"></i></button>
            </div>
        </div>

        <div class="chat-stage p-3 position-relative">
            <div class="avatar-wrapper robot-wrapper text-center">
                <div id="robot-speech-bubble" class="speech-bubble robot-bubble shadow-sm fade-in">
                    <span id="robot-bubble-text">¡Hola! Soy tu asistente vocacional. ¿En qué te puedo ayudar hoy?</span>
                </div>
                <div class="avatar-img-box robot-avatar mt-2">
                    <div class="robot-head">
                        <div class="headphone"></div>
                        <div class="eyes"><span class="eye left"></span><span class="eye right"></span></div>
                        <div class="smile"></div>
                    </div>
                    <div class="robot-body">
                        <div class="chest-screen"></div>
                    </div>
                </div>
                <span class="badge bg-purple mt-1">SISVOV Bot</span>
            </div>

            <div class="avatar-wrapper user-wrapper text-center">
                <div id="user-speech-bubble" class="speech-bubble user-bubble shadow-sm fade-in opacity-0">
                    <span id="user-bubble-text">...</span>
                </div>
                <div class="avatar-img-box human-avatar mt-2">
                    <div class="human-head">
                        <div class="hair"></div>
                        <div class="headset-mic"></div>
                        <div class="human-face"></div>
                    </div>
                    <div class="human-body"></div>
                </div>
                <span class="badge bg-secondary mt-1">Usuario</span>
            </div>
        </div>

        <div id="chat-body" class="chat-body p-3 overflow-auto">
            <div id="messages-list" aria-live="polite" aria-relevant="additions"></div>
            
            <div id="typing-indicator" class="d-none text-muted small p-2">
                <i class="bi bi-robot spin"></i> Escribiendo...
            </div>
        </div>

        <div class="quick-suggestions p-2 bg-light border-top d-flex gap-1 overflow-x-auto">
            <button class="btn btn-xs btn-outline-primary chip-btn" onclick="sendQuickMessage('¿Qué carreras ofrecen?')">🎓 Carreras</button>
            <button class="btn btn-xs btn-outline-primary chip-btn" onclick="sendQuickMessage('¿Cómo funcionan las becas?')">💰 Becas</button>
            <button class="btn btn-xs btn-outline-primary chip-btn" onclick="sendQuickMessage('Iniciar test vocacional')">📝 Test</button>
        </div>

        <div class="chat-footer p-2 bg-white border-top d-flex align-items-center gap-2">
            <button id="voice-btn" class="btn btn-light text-danger rounded-circle" title="Usar Micrófono">
                <i class="bi bi-mic-fill"></i>
            </button>
            <input type="text" id="user-input" class="form-control rounded-pill" placeholder="Escribe tu consulta aquí..." autocomplete="off" maxlength="500" aria-label="Escribe tu consulta">
            <button id="send-btn" class="btn btn-primary rounded-circle">
                <i class="bi bi-send-fill"></i>
            </button>
        </div>
    </div>

    <div class="modal fade" id="maintenanceModal" tabindex="-1" aria-labelledby="maintenanceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold" id="maintenanceModalLabel">
                        <i class="bi bi-wrench-adjustable-circle"></i> Buzón de Mantenimiento y Reportes
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small">Reporta cualquier falla técnica, error en las respuestas o sugerencia para mantener actualizado el sistema SISVOV.</p>
                    <form id="maintenance-form">
                        <div id="form-alert" class="alert d-none"></div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Tipo de Reporte</label>
                            <select id="report-type" class="form-select" required>
                                <option value="Error Técnico">Error Técnico / Bug en el Chatbot</option>
                                <option value="Actualización">Actualización de Carreras o Becas</option>
                                <option value="Sugerencia">Sugerencia de Mejora</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Correo Electrónico (Contacto)</label>
                            <input type="email" id="report-email" class="form-control" placeholder="tu@correo.com" maxlength="150" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Detalle del Mensaje</label>
                            <textarea id="report-message" class="form-control" rows="3" placeholder="Describe la falla o sugerencia en detalle..." minlength="10" maxlength="3000" required></textarea>
                        </div>
                        <button type="submit" id="btn-submit-report" class="btn btn-warning w-100 fw-bold">
                            <span>Enviar Reporte a Mantenimiento</span>
                            <div class="spinner-border spinner-border-sm d-none ms-2" role="status" id="submit-spinner"></div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>