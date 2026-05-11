<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'uniska_latihan_mvc_2026';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Password baru
    $admin_password = 'admin123';
    $user_password = 'user123';
    
    // Hash password dengan bcrypt
    $hash_admin = password_hash($admin_password, PASSWORD_DEFAULT);
    $hash_user = password_hash($user_password, PASSWORD_DEFAULT);
    
    echo "<h2>Reset Password Users</h2>";
    echo "<p>Password admin: <strong>admin123</strong></p>";
    echo "<p>Password user: <strong>user123</strong></p>";
    echo "<hr>";
    
    // Update password admin
    $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE username = 'admin'");
    if ($stmt->execute(['password' => $hash_admin])) {
        echo "<p style='color:green'>✅ Password admin berhasil direset!</p>";
    } else {
        echo "<p style='color:red'>❌ Gagal reset password admin</p>";
    }
    
    // Update password user
    $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE username = 'user'");
    if ($stmt->execute(['password' => $hash_user])) {
        echo "<p style='color:green'>✅ Password user berhasil direset!</p>";
    } else {
        echo "<p style='color:red'>❌ Gagal reset password user</p>";
    }
    
    // Tampilkan hash untuk pengecekan
    echo "<hr>";
    echo "<h3>Hash yang digunakan:</h3>";
    echo "<p>Admin hash: <code>$hash_admin</code></p>";
    echo "<p>User hash: <code>$hash_user</code></p>";
    
    // Test verifikasi
    echo "<hr>";
    echo "<h3>Test Verifikasi:</h3>";
    if (password_verify('admin123', $hash_admin)) {
        echo "<p style='color:green'>✅ Verifikasi admin123 BERHASIL</p>";
    } else {
        echo "<p style='color:red'>❌ Verifikasi admin123 GAGAL</p>";
    }
    
    if (password_verify('user123', $hash_user)) {
        echo "<p style='color:green'>✅ Verifikasi user123 BERHASIL</p>";
    } else {
        echo "<p style='color:red'>❌ Verifikasi user123 GAGAL</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}
?>