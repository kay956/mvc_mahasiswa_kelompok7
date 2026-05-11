<?php
// Konfigurasi Google OAuth 2.0
// Dapatkan Client ID dan Client Secret dari https://console.cloud.google.com/

return [
    'client_id' => '542004077056-u97ijk85k3thv8ubtiliptqr3jbb3jcd.apps.googleusercontent.com',  // GANTI DENGAN CLIENT ID ASLI
    'client_secret' => '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',                      // GANTI DENGAN CLIENT SECRET ASLI
    'redirect_uri' => 'http://localhost/mvc_mahasiswa/google-callback',  // WAJIB SAMA PERSIS DENGAN DI GOOGLE CONSOLE
    'scopes' => [
        'email',
        'profile'
    ]
];
?>