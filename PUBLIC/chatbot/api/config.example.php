<?php
return [
    'db_host' => '127.0.0.1',
    'db_port' => '3306',
    'db_name' => 'sisvov_db',
    'db_user' => 'root', 
    'db_password' => '',

    // Para la prueba manual usa http://127.0.0.1:5678/webhook-test/sisvov-chat
    'n8n_webhook_url' => 'http://127.0.0.1:5678/webhook/sisvov-chat',

    'n8n_header_name' => 'X-SISVOV-TOKEN',
    'n8n_header_secret' => 'REEMPLAZAR_POR_UN_SECRETO_LARGO_Y_ALEATORIO',
];
