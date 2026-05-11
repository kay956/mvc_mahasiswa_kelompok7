<?php
class Router {
    public function run() {
        // Ambil URL parameter
        $url = isset($_GET['url']) ? $_GET['url'] : '';
        $url = rtrim($url, '/');
        
        // JIKA URL KOSONG, SET DEFAULT KE 'home/index'
        if (empty($url)) {
            $url = 'home/index';
        }
        
        $urlParts = explode('/', $url);
        
        $controllerName = ucfirst($urlParts[0]) . 'Controller';
        $method = isset($urlParts[1]) ? $urlParts[1] : 'index';
        $params = array_slice($urlParts, 2);
        
        // Redirect /login ke /auth/login
        if ($controllerName == 'LoginController') {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
        
        $controllerFile = "../app/controllers/$controllerName.php";
        
        if (!file_exists($controllerFile)) {
            echo "<h3>Error 404: Controller '$controllerName' tidak ditemukan</h3>";
            echo "<p>File: $controllerFile</p>";
            return;
        }
        
        require_once $controllerFile;
        $controller = new $controllerName();
        
        if (!method_exists($controller, $method)) {
            echo "<h3>Error 404: Method '$method' tidak ditemukan di $controllerName</h3>";
            return;
        }
        
        call_user_func_array([$controller, $method], $params);
    }
}
?>