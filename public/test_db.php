<?php
require_once '../config/database.php';
require_once '../core/Database.php';

try {
    $db = Database::getConnection();
    echo "<h2 style='color: green;'>✅ Koneksi berhasil!</h2>";
    echo "<p>Database: uniska_latihan_mvc_2026</p>";
    
    // Test query
    $stmt = $db->query("SELECT COUNT(*) as total FROM mahasiswa");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Jumlah data mahasiswa: " . $result['total'] . "</p>";
    
} catch (PDOException $e) {
    echo "<h2 style='color: red;'>❌ Koneksi gagal!</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>