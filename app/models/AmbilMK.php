<?php
class AmbilMK {
    private $db;
    
    public function __construct() {
        $this->db = Database::getConnection();
    }
    
    public function getByMahasiswa($mahasiswa_id) {
        $sql = "SELECT mk.*, am.nilai, am.id as ambil_id 
                FROM ambil_mk am 
                JOIN mata_kuliah mk ON am.mata_kuliah_id = mk.id 
                WHERE am.mahasiswa_id = :mahasiswa_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['mahasiswa_id' => $mahasiswa_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getById($id) {
        $sql = "SELECT * FROM ambil_mk WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function add($mahasiswa_id, $mata_kuliah_id, $nilai = null) {
        $sql = "INSERT INTO ambil_mk (mahasiswa_id, mata_kuliah_id, nilai) 
                VALUES (:mahasiswa_id, :mata_kuliah_id, :nilai)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'mahasiswa_id' => $mahasiswa_id,
            'mata_kuliah_id' => $mata_kuliah_id,
            'nilai' => $nilai
        ]);
    }
    
    public function delete($id) {
        $sql = "DELETE FROM ambil_mk WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    
    public function updateNilai($id, $nilai) {
        $sql = "UPDATE ambil_mk SET nilai = :nilai WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id, 'nilai' => $nilai]);
    }
}
?>