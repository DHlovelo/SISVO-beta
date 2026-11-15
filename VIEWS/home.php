<main class="container py-5 text-center">
    <h1 class="display-6 fw-bold mb-2">Descubre qué carrera va contigo</h1>
    <p class="text-secondary mb-4">
        SISVOV te orienta con un chatbot, un test vocacional y la información de universidades,
        institutos y becas en un solo lugar.
    </p>

    <div class="d-flex justify-content-center flex-wrap gap-2 mb-5">
        <a href="<?= url('test') ?>" class="btn btn-light rounded-pill px-4 fw-semibold">Hacer el test</a>
        <a href="<?= url('registro') ?>" class="btn btn-outline-light rounded-pill px-4">Crear cuenta</a>
    </div>

    <div class="row g-4 text-start">
        <div class="col-md-4">
            <div class="card card-sisvov rounded-4 h-100"><div class="card-body p-4">
                <div class="fs-2 mb-2">🤖</div>
                <h5 class="fw-bold">Chatea con el asistente</h5>
                <p class="text-secondary mb-0">Pregunta sobre el test, las instituciones y las becas.</p>
            </div></div>
        </div>
        <div class="col-md-4">
            <div class="card card-sisvov rounded-4 h-100"><div class="card-body p-4">
                <div class="fs-2 mb-2">📝</div>
                <h5 class="fw-bold">Haz el test vocacional</h5>
                <p class="text-secondary mb-0">preguntas rápidas para conocer tu perfil y las carreras afines.</p>
            </div></div>
        </div>
        <div class="col-md-4">
            <div class="card card-sisvov rounded-4 h-100"><div class="card-body p-4">
                <div class="fs-2 mb-2">🎓</div>
                <h5 class="fw-bold">Explora instituciones y becas</h5>
                <p class="text-secondary mb-0">Directorio de universidades e institutos, y becas con sus requisitos.</p>
            </div></div>
        </div>
    </div>
</main>
