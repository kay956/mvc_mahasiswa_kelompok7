<?php
// File ini untuk kompatibilitas dengan kode lama
// Sebenarnya koneksi utama ada di core/Database.php

function getConnection() {
    return Database::getConnection();
}
?>