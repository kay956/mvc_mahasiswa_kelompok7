<?php
class MataKuliah {
    private $db;
    
    public function __construct() {
        $this->db = Database::getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM mata_kuliah ORDER BY id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM mata_kuliah WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO mata_kuliah (kode_mk, nama_mk, sks) VALUES (:kode_mk, :nama_mk, :sks)");
        return $stmt->execute($data);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE mata_kuliah SET kode_mk = :kode_mk, nama_mk = :nama_mk, sks = :sks WHERE id = :id");
        $data['id'] = $id;
        return $stmt->execute($data);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM mata_kuliah WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>