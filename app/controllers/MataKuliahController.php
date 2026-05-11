<?php
class MataKuliahController extends Controller {
    
    private function isAdmin() {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }
    
    private function isLoggedIn() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }
    
    public function index() {
        $this->isLoggedIn();
        if (!$this->isAdmin()) {
            $this->setFlash('error', 'Akses ditolak!');
            header('Location: ' . BASEURL . '/mahasiswa');
            return;
        }
        
        $model = $this->model('MataKuliah');
        $data['matakuliah'] = $model->getAll();
        $data['title'] = 'Data Mata Kuliah';
        $this->view('matakuliah/index', $data);
    }
    
    public function create() {
        $this->isLoggedIn();
        if (!$this->isAdmin()) return;
        
        $data['title'] = 'Tambah Mata Kuliah';
        $this->view('matakuliah/create', $data);
    }
    
    public function store() {
        $this->isLoggedIn();
        if (!$this->isAdmin()) return;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = $this->model('MataKuliah');
            if ($model->create($_POST)) {
                $this->setFlash('success', 'Mata kuliah berhasil ditambahkan');
            } else {
                $this->setFlash('error', 'Gagal menambahkan');
            }
        }
        header('Location: ' . BASEURL . '/matakuliah');
    }
    
    public function edit($id) {
        $this->isLoggedIn();
        if (!$this->isAdmin()) return;
        
        $model = $this->model('MataKuliah');
        $data['mk'] = $model->find($id);
        $data['title'] = 'Edit Mata Kuliah';
        $this->view('matakuliah/edit', $data);
    }
    
    public function update($id) {
        $this->isLoggedIn();
        if (!$this->isAdmin()) return;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = $this->model('MataKuliah');
            if ($model->update($id, $_POST)) {
                $this->setFlash('success', 'Mata kuliah berhasil diupdate');
            }
        }
        header('Location: ' . BASEURL . '/matakuliah');
    }
    
    public function delete($id) {
        $this->isLoggedIn();
        if (!$this->isAdmin()) return;
        
        $model = $this->model('MataKuliah');
        $model->delete($id);
        $this->setFlash('success', 'Mata kuliah dihapus');
        header('Location: ' . BASEURL . '/matakuliah');
    }
}
?>