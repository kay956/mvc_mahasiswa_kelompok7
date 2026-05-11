<?php
class Mahasiswa {
    private $db;
    
    public function __construct() {
        $this->db = Database::getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM mahasiswa ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM mahasiswa WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function isNpmExist($npm, $excludeId = null) {
        if ($excludeId) {
            $stmt = $this->db->prepare("SELECT id FROM mahasiswa WHERE npm = :npm AND id != :id");
            $stmt->execute(['npm' => $npm, 'id' => $excludeId]);
        } else {
            $stmt = $this->db->prepare("SELECT id FROM mahasiswa WHERE npm = :npm");
            $stmt->execute(['npm' => $npm]);
        }
        return $stmt->fetch() !== false;
    }
    
    public function findByNpmExceptId($npm, $id) {
        $stmt = $this->db->prepare("SELECT id FROM mahasiswa WHERE npm = :npm AND id != :id");
        $stmt->execute(['npm' => $npm, 'id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function create($data) {
        $sql = "INSERT INTO mahasiswa (npm, nama_lengkap, fakultas, jurusan, tempat_lahir, tanggal_lahir, jenis_kelamin, status_id) 
                VALUES (:npm, :nama_lengkap, :fakultas, :jurusan, :tempat_lahir, :tanggal_lahir, :jenis_kelamin, 1)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'npm' => $data['npm'],
            'nama_lengkap' => $data['nama_lengkap'],
            'fakultas' => $data['fakultas'],
            'jurusan' => $data['jurusan'],
            'tempat_lahir' => $data['tempat_lahir'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'jenis_kelamin' => $data['jenis_kelamin']
        ]);
    }
    
    public function update($id, $data) {
        $sql = "UPDATE mahasiswa SET 
                npm = :npm,
                nama_lengkap = :nama_lengkap,
                fakultas = :fakultas,
                jurusan = :jurusan,
                tempat_lahir = :tempat_lahir,
                tanggal_lahir = :tanggal_lahir,
                jenis_kelamin = :jenis_kelamin
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'npm' => $data['npm'],
            'nama_lengkap' => $data['nama_lengkap'],
            'fakultas' => $data['fakultas'],
            'jurusan' => $data['jurusan'],
            'tempat_lahir' => $data['tempat_lahir'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'jenis_kelamin' => $data['jenis_kelamin']
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM mahasiswa WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    
    public function searchAndFilter($search = '', $jurusan = '') {
        $sql = "SELECT * FROM mahasiswa WHERE 1=1";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (npm LIKE :search OR nama_lengkap LIKE :search)";
            $params['search'] = "%$search%";
        }
        
        if (!empty($jurusan)) {
            $sql .= " AND jurusan = :jurusan";
            $params['jurusan'] = $jurusan;
        }
        
        $sql .= " ORDER BY id DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>