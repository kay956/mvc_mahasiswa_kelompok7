<?php
header('Content-Type: application/json');

class ApiMahasiswaController extends Controller {
    
    private function sendResponse($data, $status = 200) {
        http_response_code($status);
        echo json_encode($data);
        exit;
    }
    
    // GET /api/mahasiswa
    public function index() {
        $model = $this->model('Mahasiswa');
        $data = $model->getAll();
        $this->sendResponse([
            'status' => 'success',
            'total' => count($data),
            'data' => $data
        ]);
    }
    
    // GET /api/mahasiswa/{id}
    public function show($id) {
        $model = $this->model('Mahasiswa');
        $data = $model->find($id);
        
        if (!$data) {
            $this->sendResponse(['status' => 'error', 'message' => 'Mahasiswa tidak ditemukan'], 404);
        }
        
        $this->sendResponse(['status' => 'success', 'data' => $data]);
    }
    
    // POST /api/mahasiswa
    public function store() {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            $this->sendResponse(['status' => 'error', 'message' => 'Invalid JSON'], 400);
        }
        
        $model = $this->model('Mahasiswa');
        
        if ($model->isNpmExist($input['npm'])) {
            $this->sendResponse(['status' => 'error', 'message' => 'NPM sudah terdaftar'], 409);
        }
        
        if ($model->create($input)) {
            $this->sendResponse(['status' => 'success', 'message' => 'Data berhasil ditambahkan'], 201);
        } else {
            $this->sendResponse(['status' => 'error', 'message' => 'Gagal menambahkan data'], 500);
        }
    }
    
    // PUT /api/mahasiswa/{id}
    public function update($id) {
        $input = json_decode(file_get_contents('php://input'), true);
        
        $model = $this->model('Mahasiswa');
        $existing = $model->find($id);
        
        if (!$existing) {
            $this->sendResponse(['status' => 'error', 'message' => 'Mahasiswa tidak ditemukan'], 404);
        }
        
        if ($model->update($id, $input)) {
            $this->sendResponse(['status' => 'success', 'message' => 'Data berhasil diupdate']);
        } else {
            $this->sendResponse(['status' => 'error', 'message' => 'Gagal mengupdate data'], 500);
        }
    }
    
    // DELETE /api/mahasiswa/{id}
    public function delete($id) {
        $model = $this->model('Mahasiswa');
        $existing = $model->find($id);
        
        if (!$existing) {
            $this->sendResponse(['status' => 'error', 'message' => 'Mahasiswa tidak ditemukan'], 404);
        }
        
        if ($model->delete($id)) {
            $this->sendResponse(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } else {
            $this->sendResponse(['status' => 'error', 'message' => 'Gagal menghapus data'], 500);
        }
    }
}
?>