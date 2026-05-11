<?php
echo "<h2>Path Diagnosis for google.php</h2>";

// Semua kemungkinan path
$possiblePaths = [
    'From __DIR__' => __DIR__ . '/../config/google.php',
    'From getcwd()' => getcwd() . '/../config/google.php',
    'Absolute path' => 'C:\\xampp\\htdocs\\mvc_mahasiswa\\config\\google.php',
    'From DOCUMENT_ROOT' => $_SERVER['DOCUMENT_ROOT'] . '/mvc_mahasiswa/config/google.php',
];

foreach ($possiblePaths as $name => $path) {
    $realPath = realpath($path);
    if ($realPath && file_exists($realPath)) {
        echo "<p style='color:green'>✅ <strong>$name</strong>: <code>$realPath</code> - FOUND</p>";
    } else {
        echo "<p style='color:red'>❌ <strong>$name</strong>: <code>$path</code> - NOT FOUND</p>";
    }
}

// Cek isi folder config secara manual
echo "<h3>Manual directory listing:</h3>";
$configDir = __DIR__ . '/../config';
if (is_dir($configDir)) {
    echo "<p>Directory exists: $configDir</p>";
    $files = scandir($configDir);
    echo "<ul>";
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo "<li>$file</li>";
        }
    }
    echo "</ul>";
} else {
    echo "<p style='color:red'>Directory NOT found: $configDir</p>";
}

// Cek current working directory
echo "<h3>Current working directory:</h3>";
echo "<p>" . getcwd() . "</p>";

// Cek apakah ada open_basedir restriction
echo "<h3>open_basedir setting:</h3>";
$openBasedir = ini_get('open_basedir');
if ($openBasedir) {
    echo "<p style='color:orange'>⚠️ open_basedir is active: $openBasedir</p>";
    echo "<p>This restricts PHP to only access files within these directories.</p>";
} else {
    echo "<p style='color:green'>✅ No open_basedir restriction</p>";
}
?>