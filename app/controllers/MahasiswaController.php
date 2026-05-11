<?php

class MahasiswaController extends Controller {

    private function isLoggedIn() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }
    
    private function isAdmin() {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }
    
    public function index() {
        $this->isLoggedIn();
        
        $search = $_GET['search'] ?? '';
        $jurusan = $_GET['jurusan'] ?? '';
        
        $mahasiswaModel = $this->model('Mahasiswa');
        
        if (!empty($search) || !empty($jurusan)) {
            $data['mahasiswa'] = $mahasiswaModel->searchAndFilter($search, $jurusan);
            $data['search'] = $search;
            $data['jurusanFilter'] = $jurusan;
        } else {
            $data['mahasiswa'] = $mahasiswaModel->getAll();
            $data['search'] = '';
            $data['jurusanFilter'] = '';
        }
        
        $data['isAdmin'] = $this->isAdmin();
        $data['title'] = 'Data Mahasiswa';
        
        $this->view('mahasiswa/index', $data);
    }
    
    public function create() {
        $this->isLoggedIn();
        
        if (!$this->isAdmin()) {
            $this->setFlash('error', 'Akses ditolak! Hanya admin yang bisa menambah data.');
            header('Location: ' . BASEURL . '/mahasiswa');
            return;
        }
        
        $data['title'] = 'Tambah Mahasiswa';
        $this->view('mahasiswa/create', $data);
    }
    
    public function store() {
        $this->isLoggedIn();
        
        if (!$this->isAdmin()) {
            $this->setFlash('error', 'Akses ditolak!');
            header('Location: ' . BASEURL . '/mahasiswa');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mahasiswaModel = $this->model('Mahasiswa');
            
            if ($mahasiswaModel->isNpmExist($_POST['npm'])) {
                $this->setFlash('error', 'NPM sudah terdaftar!');
                header('Location: ' . BASEURL . '/mahasiswa/create');
                return;
            }
            
            if (!ctype_digit($_POST['npm'])) {
                $this->setFlash('error', 'NPM harus berupa angka!');
                header('Location: ' . BASEURL . '/mahasiswa/create');
                return;
            }
            
            if ($mahasiswaModel->create($_POST)) {
                $this->setFlash('success', 'Data mahasiswa berhasil ditambahkan!');
            } else {
                $this->setFlash('error', 'Gagal menambahkan data!');
            }
        }
        
        header('Location: ' . BASEURL . '/mahasiswa');
    }
    
    public function edit($id) {
        $this->isLoggedIn();
        
        if (!$this->isAdmin()) {
            $this->setFlash('error', 'Akses ditolak! Hanya admin yang bisa mengedit data.');
            header('Location: ' . BASEURL . '/mahasiswa');
            return;
        }
        
        $mahasiswaModel = $this->model('Mahasiswa');
        $data['m'] = $mahasiswaModel->find($id);
        
        if (!$data['m']) {
            $this->setFlash('error', 'Data mahasiswa tidak ditemukan!');
            header('Location: ' . BASEURL . '/mahasiswa');
            return;
        }
        
        $data['title'] = 'Edit Mahasiswa';
        $this->view('mahasiswa/edit', $data);
    }
    
    public function update($id) {
        $this->isLoggedIn();
        
        if (!$this->isAdmin()) {
            $this->setFlash('error', 'Akses ditolak!');
            header('Location: ' . BASEURL . '/mahasiswa');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mahasiswaModel = $this->model('Mahasiswa');
            
            $existing = $mahasiswaModel->findByNpmExceptId($_POST['npm'], $id);
            if ($existing) {
                $this->setFlash('error', 'NPM sudah digunakan oleh mahasiswa lain!');
                header('Location: ' . BASEURL . '/mahasiswa/edit/' . $id);
                return;
            }
            
            if ($mahasiswaModel->update($id, $_POST)) {
                $this->setFlash('success', 'Data mahasiswa berhasil diupdate!');
            } else {
                $this->setFlash('error', 'Gagal mengupdate data!');
            }
        }
        
        header('Location: ' . BASEURL . '/mahasiswa');
    }
    
    public function delete($id) {
        $this->isLoggedIn();
        
        if (!$this->isAdmin()) {
            $this->setFlash('error', 'Akses ditolak! Hanya admin yang bisa menghapus data.');
            header('Location: ' . BASEURL . '/mahasiswa');
            return;
        }
        
        $mahasiswaModel = $this->model('Mahasiswa');
        
        if ($mahasiswaModel->delete($id)) {
            $this->setFlash('success', 'Data mahasiswa berhasil dihapus!');
        } else {
            $this->setFlash('error', 'Gagal menghapus data!');
        }
        
        header('Location: ' . BASEURL . '/mahasiswa');
    }
    
    public function exportCSV() {
        $this->isLoggedIn();
        
        $search = $_GET['search'] ?? '';
        $jurusan = $_GET['jurusan'] ?? '';
        
        $mahasiswaModel = $this->model('Mahasiswa');
        
        if (!empty($search) || !empty($jurusan)) {
            $data = $mahasiswaModel->searchAndFilter($search, $jurusan);
        } else {
            $data = $mahasiswaModel->getAll();
        }
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="data_mahasiswa_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'NPM', 'Nama Lengkap', 'Fakultas', 'Jurusan', 'Tempat Lahir', 'Tanggal Lahir', 'Jenis Kelamin', 'Status']);
        
        foreach ($data as $row) {
            $status = ($row['status_id'] == 1) ? 'Aktif' : 'Nonaktif';
            fputcsv($output, [
                $row['id'],
                $row['npm'],
                $row['nama_lengkap'],
                $row['fakultas'],
                $row['jurusan'],
                $row['tempat_lahir'],
                $row['tanggal_lahir'],
                $row['jenis_kelamin'],
                $status
            ]);
        }
        
        fclose($output);
        exit;
    }
    
    public function exportPDF() {
        $this->isLoggedIn();
        
        require_once __DIR__ . '/../../vendor/autoload.php';
        
        $search = $_GET['search'] ?? '';
        $jurusan = $_GET['jurusan'] ?? '';
        
        $mahasiswaModel = $this->model('Mahasiswa');
        
        if (!empty($search) || !empty($jurusan)) {
            $data = $mahasiswaModel->searchAndFilter($search, $jurusan);
        } else {
            $data = $mahasiswaModel->getAll();
        }
        
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Data Mahasiswa</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h2 { text-align: center; color: #333; margin-bottom: 5px; }
                .subtitle { text-align: center; color: #666; margin-bottom: 20px; font-size: 14px; }
                .date { text-align: right; margin-bottom: 20px; font-size: 12px; }
                table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 11px; }
                th, td { border: 1px solid #ddd; padding: 8px 5px; text-align: left; vertical-align: top; }
                th { background-color: #4CAF50; color: white; font-weight: bold; }
                tr:nth-child(even) { background-color: #f2f2f2; }
                .footer { margin-top: 20px; text-align: center; font-size: 10px; color: #666; }
                .badge-aktif { background-color: #4CAF50; color: white; padding: 2px 6px; border-radius: 3px; font-size: 10px; }
                .badge-nonaktif { background-color: #f44336; color: white; padding: 2px 6px; border-radius: 3px; font-size: 10px; }
            </style>
        </head>
        <body>
            <h2>LAPORAN DATA MAHASISWA</h2>
            <div class="subtitle">Program Studi Teknik Informatika & Sistem Informasi</div>
            <div class="date">Tanggal Cetak: ' . date('d/m/Y H:i:s') . '</div>
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="12%">NPM</th>
                        <th width="18%">Nama Lengkap</th>
                        <th width="10%">Fakultas</th>
                        <th width="15%">Jurusan</th>
                        <th width="12%">Tempat Lahir</th>
                        <th width="10%">Tgl Lahir</th>
                        <th width="10%">Jenis Kelamin</th>
                        <th width="8%">Status</th>
                    </tr>
                </thead>
                <tbody>';
        
        $no = 1;
        foreach ($data as $row) {
            $status = ($row['status_id'] == 1) ? '<span class="badge-aktif">Aktif</span>' : '<span class="badge-nonaktif">Nonaktif</span>';
            $tanggal_lahir = ($row['tanggal_lahir'] && $row['tanggal_lahir'] != '0000-00-00') 
                             ? date('d/m/Y', strtotime($row['tanggal_lahir'])) 
                             : '-';
            
            $html .= '对接
                        <td>' . $no++ . '</td>
                        <td>' . htmlspecialchars($row['npm']) . '</td>
                        <td>' . htmlspecialchars($row['nama_lengkap']) . '</td>
                        <td>' . htmlspecialchars($row['fakultas'] ?: '-') . '</td>
                        <td>' . htmlspecialchars($row['jurusan']) . '</td>
                        <td>' . htmlspecialchars($row['tempat_lahir'] ?: '-') . '</td>
                        <td>' . $tanggal_lahir . '</td>
                        <td>' . htmlspecialchars($row['jenis_kelamin']) . '</td>
                        <td>' . $status . '</td>
                    </tr>';
        }
        
        $html .= '
                </tbody>
            </table>
            <div class="footer">
                Dicetak dari Aplikasi MVC Mahasiswa<br>
                Praktikum Pemrograman Web - FTI UNISKA 2026
            </div>
        </body>
        </html>';
        
        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("data_mahasiswa_" . date('Y-m-d') . ".pdf", array("Attachment" => true));
        exit;
    }
    
    // ========== DETAIL MAHASISWA & MATA KULIAH ==========
    
    public function detail($id) {
        $this->isLoggedIn();
        
        $mahasiswaModel = $this->model('Mahasiswa');
        $ambilMKModel = $this->model('AmbilMK');
        $mataKuliahModel = $this->model('MataKuliah');
        
        $data['m'] = $mahasiswaModel->find($id);
        $data['matakuliah_diambil'] = $ambilMKModel->getByMahasiswa($id);
        $data['semua_matakuliah'] = $mataKuliahModel->getAll();
        $data['title'] = 'Detail Mahasiswa';
        $data['isAdmin'] = $this->isAdmin();  // ← PENTING!
        
        $this->view('mahasiswa/detail', $data);
    }
    
    public function tambahMataKuliah() {
        $this->isLoggedIn();
        
        if (!$this->isAdmin()) {
            $this->setFlash('error', 'Akses ditolak!');
            header('Location: ' . BASEURL . '/mahasiswa');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = $this->model('AmbilMK');
            $model->add($_POST['mahasiswa_id'], $_POST['mata_kuliah_id'], $_POST['nilai'] ?? null);
            $this->setFlash('success', 'Mata kuliah berhasil ditambahkan');
            header('Location: ' . BASEURL . '/mahasiswa/detail/' . $_POST['mahasiswa_id']);
        }
    }
    
    public function hapusMataKuliah($id) {
        $this->isLoggedIn();
        
        if (!$this->isAdmin()) {
            $this->setFlash('error', 'Akses ditolak!');
            header('Location: ' . BASEURL . '/mahasiswa');
            return;
        }
        
        $model = $this->model('AmbilMK');
        $ambil = $model->getById($id);
        
        if ($ambil) {
            $mahasiswa_id = $ambil['mahasiswa_id'];
            $model->delete($id);
            $this->setFlash('success', 'Mata kuliah berhasil dihapus');
            header('Location: ' . BASEURL . '/mahasiswa/detail/' . $mahasiswa_id);
        } else {
            $this->setFlash('error', 'Data tidak ditemukan');
            header('Location: ' . BASEURL . '/mahasiswa');
        }
    }
}
?>