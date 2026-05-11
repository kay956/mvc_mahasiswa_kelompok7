<?php
require_once __DIR__ . '/../../vendor/autoload.php';

class GoogleAuthController {
    
    private $client;
    
    public function __construct() {
        // PAKAI ABSOLUTE PATH LANGSUNG
        $configPath = 'C:\\xampp\\htdocs\\mvc_mahasiswa\\config\\google.php';
        
        // Atau pakai ini (lebih portable)
        // $configPath = $_SERVER['DOCUMENT_ROOT'] . '/mvc_mahasiswa/config/google.php';
        
        if (!file_exists($configPath)) {
            die("File config/google.php tidak ditemukan di: " . $configPath);
        }
        
        $config = require $configPath;
        
        // Verifikasi config terbaca
        if (!isset($config['client_id']) || $config['client_id'] == 'YOUR_CLIENT_ID.apps.googleusercontent.com') {
            die("Client ID belum diisi dengan benar di config/google.php");
        }
        
        // Inisialisasi Google Client
        $this->client = new \Google_Client();
        $this->client->setClientId($config['client_id']);
        $this->client->setClientSecret($config['client_secret']);
        $this->client->setRedirectUri($config['redirect_uri']);
        $this->client->addScope($config['scopes']);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
    }
    
    public function login() {
        $authUrl = $this->client->createAuthUrl();
        header('Location: ' . $authUrl);
        exit;
    }
    
    public function callback() {
        if (isset($_GET['error'])) {
            $_SESSION['flash']['error'] = 'Login Google dibatalkan: ' . htmlspecialchars($_GET['error']);
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
        
        if (!isset($_GET['code'])) {
            $_SESSION['flash']['error'] = 'Login Google gagal: Tidak ada kode autentikasi';
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
        
        try {
            $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
            
            if (isset($token['error'])) {
                throw new Exception($token['error_description'] ?? $token['error']);
            }
            
            $this->client->setAccessToken($token);
            
            $oauth2 = new \Google_Service_Oauth2($this->client);
            $userInfo = $oauth2->userinfo->get();
            
            // Load model User
            require_once __DIR__ . '/../models/User.php';
            $userModel = new User();
            
            // Cek apakah user sudah ada
            $existingUser = $userModel->findByEmail($userInfo->email);
            
            if (!$existingUser) {
                // Auto register jika belum punya akun
                $userData = [
                    'email' => $userInfo->email,
                    'name' => $userInfo->name,
                    'google_id' => $userInfo->id,
                    'avatar' => $userInfo->picture,
                    'role' => 'user'
                ];
                
                $newUserId = $userModel->createFromGoogle($userData);
                $user = $userModel->find($newUserId);
                $_SESSION['flash']['success'] = 'Akun berhasil dibuat! Selamat datang, ' . $userInfo->name;
            } else {
                $user = $existingUser;
                $userModel->updateLastLogin($user['id']);
                $_SESSION['flash']['success'] = 'Selamat datang kembali, ' . $userInfo->name;
            }
            
            // Set session
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'] ?? $userInfo->email,
                'email' => $userInfo->email,
                'name' => $userInfo->name,
                'avatar' => $userInfo->picture,
                'role' => $user['role'] ?? 'user',
                'login_via' => 'google'
            ];
            
            header('Location: ' . BASEURL . '/mahasiswa');
            
        } catch (Exception $e) {
            error_log("Google Login Error: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Login Google gagal: ' . $e->getMessage();
            header('Location: ' . BASEURL . '/auth/login');
        }
        exit;
    }
}
?>