<?php
class LoginController extends Controller {
    
    // Redirect ke AuthController
    public function index() {
        header('Location: ' . BASEURL . '/auth/login');
        exit;
    }
    
    // Redirect untuk method lain
    public function __call($name, $arguments) {
        header('Location: ' . BASEURL . '/auth/login');
        exit;
    }
}
?>