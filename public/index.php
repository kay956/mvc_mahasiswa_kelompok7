<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

define('BASEURL', 'http://localhost/mvc_mahasiswa/public/index.php');

require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Database.php';

spl_autoload_register(function($class) {
    $paths = [
        __DIR__ . '/../app/controllers/' . $class . '.php',
        __DIR__ . '/../app/models/' . $class . '.php'
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// ========== ROUTING API ==========
if (isset($_GET['url']) && strpos($_GET['url'], 'api/') === 0) {
    require_once __DIR__ . '/../app/controllers/ApiMahasiswaController.php';
    $api = new ApiMahasiswaController();
    
    $url = str_replace('api/', '', $_GET['url']);
    $parts = explode('/', $url);
    $method = $_SERVER['REQUEST_METHOD'];
    $id = $parts[1] ?? null;
    
    switch ($method) {
        case 'GET':
            if ($id) $api->show($id);
            else $api->index();
            break;
        case 'POST':
            $api->store();
            break;
        case 'PUT':
            $api->update($id);
            break;
        case 'DELETE':
            $api->delete($id);
            break;
        default:
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    }
    exit;
}

// ========== ROUTING GOOGLE AUTH (AKTIF) ==========
if (isset($_GET['url'])) {
    if ($_GET['url'] == 'google-auth/login') {
        require_once __DIR__ . '/../app/controllers/GoogleAuthController.php';
        $ctrl = new GoogleAuthController();
        $ctrl->login();
        exit;
    }
    if ($_GET['url'] == 'google-callback') {
        require_once __DIR__ . '/../app/controllers/GoogleAuthController.php';
        $ctrl = new GoogleAuthController();
        $ctrl->callback();
        exit;
    }
}

// ========== ROUTER UTAMA ==========
$router = new Router();
$router->run();
?>