<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-7">

            <div class="card card-sisvov shadow-lg rounded-4 border-0">
                <div class="card-body p-4 p-md-5 text-center">

                    <span class="badge rounded-pill bg-secondary-subtle text-secondary-emphasis mb-3">
                        Tu resultado
                    </span>

                    <div class="resultado-codigo" id="codigo">----</div>

                    <h2 class="h4 text-secondary mt-3 mb-4" id="tituloPerfil">
                        Calculando...
                    </h2>

                    <div class="alert alert-secondary text-start rounded-3 border-0"
                         id="descPerfil" role="alert"></div>

                    <div class="text-start mb-4">
                        <h6 class="text-secondary text-uppercase small fw-bold mb-3">
                            Carreras afines
                        </h6>
                        <ul class="list-group list-group-flush" id="listaCarreras"></ul>
                    </div>


                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-2 pt-3 border-top border-secondary-subtle"
                         id="accionesResultado">
                        <a href="<?= url('test') ?>" class="btn btn-outline-light rounded-pill px-4">
                            Repetir test
                        </a>
                        <a href="#" class="btn btn-light rounded-pill px-4 fw-semibold"
                           id="btnVerCarreras">
                            Ver carreras →
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</main>
