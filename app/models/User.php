<?php
class User {
    private $db;
    
    public function __construct() {
        $this->db = Database::getConnection();
    }
    
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Cari user berdasarkan email (untuk Google login)
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Cari user berdasarkan google_id
    public function findByGoogleId($google_id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE google_id = :google_id");
        $stmt->execute(['google_id' => $google_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Buat user baru dari data Google
    public function createFromGoogle($data) {
        $stmt = $this->db->prepare("
            INSERT INTO users (username, email, name, google_id, avatar, role, password) 
            VALUES (:username, :email, :name, :google_id, :avatar, :role, :password)
        ");
        $stmt->execute([
            'username' => $data['email'], // pakai email sebagai username
            'email' => $data['email'],
            'name' => $data['name'],
            'google_id' => $data['google_id'],
            'avatar' => $data['avatar'],
            'role' => 'user', // default role user
            'password' => password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT)
        ]);
        return $this->db->lastInsertId();
    }
    
    // Update user yang sudah ada dengan data Google
    public function updateFromGoogle($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE users SET 
                name = :name, 
                avatar = :avatar, 
                last_login = NOW() 
            WHERE id = :id
        ");
        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'avatar' => $data['avatar']
        ]);
    }
    
    // Update last login
    public function updateLastLogin($id) {
        $stmt = $this->db->prepare("UPDATE users SET last_login = NOW() WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>