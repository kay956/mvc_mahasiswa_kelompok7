<?php
class DashboardController extends Controller {
    
    private function isLoggedIn() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }
    
    public function index() {
        $this->isLoggedIn();
        
        $db = Database::getConnection();
        
        // Statistik per jurusan
        $stmt = $db->query("SELECT jurusan, COUNT(*) as total FROM mahasiswa GROUP BY jurusan");
        $data['jurusan_stats'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Statistik status (aktif/nonaktif)
        $stmt = $db->query("SELECT 
            SUM(CASE WHEN status_id = 1 THEN 1 ELSE 0 END) as aktif,
            SUM(CASE WHEN status_id = 0 THEN 1 ELSE 0 END) as nonaktif
            FROM mahasiswa");
        $statusData = $stmt->fetch(PDO::FETCH_ASSOC);
        $data['status_stats'] = [
            ['label' => 'Aktif', 'total' => $statusData['aktif']],
            ['label' => 'Nonaktif', 'total' => $statusData['nonaktif']]
        ];
        
        // Total mahasiswa
        $stmt = $db->query("SELECT COUNT(*) as total FROM mahasiswa");
        $data['total_mahasiswa'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Total mata kuliah
        $stmt = $db->query("SELECT COUNT(*) as total FROM mata_kuliah");
        $data['total_matakuliah'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        
        // Mahasiswa per fakultas
        $stmt = $db->query("SELECT fakultas, COUNT(*) as total FROM mahasiswa GROUP BY fakultas");
        $data['fakultas_stats'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // 5 Mahasiswa terbaru
        $stmt = $db->query("SELECT id, npm, nama_lengkap, jurusan, created_at FROM mahasiswa ORDER BY id DESC LIMIT 5");
        $data['mahasiswa_terbaru'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Jenis kelamin
        $stmt = $db->query("SELECT 
            SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as laki,
            SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as perempuan
            FROM mahasiswa");
        $genderData = $stmt->fetch(PDO::FETCH_ASSOC);
        $data['gender_stats'] = [
            ['label' => 'Laki-laki', 'total' => $genderData['laki']],
            ['label' => 'Perempuan', 'total' => $genderData['perempuan']]
        ];
        
        $data['title'] = 'Dashboard';
        $this->view('dashboard/index', $data);
    }
}
?>