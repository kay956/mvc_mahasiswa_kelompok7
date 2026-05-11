<?php
class AuthController extends Controller {
    
    // Halaman login
    public function login() {
        // Jika sudah login, redirect ke mahasiswa
        if (isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/mahasiswa');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            
            $userModel = $this->model('User');
            $user = $userModel->findByUsername($username);
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ];
                $this->setFlash('success', 'Selamat datang, ' . $user['username'] . '!');
                header('Location: ' . BASEURL . '/mahasiswa');
            } else {
                $this->setFlash('error', 'Username atau password salah!');
                header('Location: ' . BASEURL . '/auth/login');
            }
            return;
        }
        
        $data['title'] = 'Login';
        $this->view('auth/login', $data);
    }
    
    // Logout
    public function logout() {
        session_destroy();
        session_start();
        $this->setFlash('success', 'Anda telah logout.');
        header('Location: ' . BASEURL . '/auth/login');
    }
}
?>