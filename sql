-- Tabel mahasiswa
CREATE TABLE mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status_id INT DEFAULT 1,
    npm VARCHAR(20) UNIQUE,
    nama_lengkap VARCHAR(100),
    fakultas VARCHAR(100),
    jurusan ENUM('Teknik Informatika', 'Sistem Informasi'),
    tempat_lahir VARCHAR(50),
    tanggal_lahir DATE,
    jenis_kelamin ENUM('Laki-laki', 'Perempuan')
);

-- Tabel users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin','user') DEFAULT 'user',
    email VARCHAR(100) NULL,
    name VARCHAR(100) NULL,
    google_id VARCHAR(255) NULL,
    avatar VARCHAR(500) NULL,
    last_login DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel mata kuliah
CREATE TABLE mata_kuliah (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_mk VARCHAR(10) UNIQUE,
    nama_mk VARCHAR(100),
    sks INT DEFAULT 3,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel ambil_mk (relasi)
CREATE TABLE ambil_mk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mahasiswa_id INT,
    mata_kuliah_id INT,
    nilai CHAR(2) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mahasiswa_id) REFERENCES mahasiswa(id) ON DELETE CASCADE,
    FOREIGN KEY (mata_kuliah_id) REFERENCES mata_kuliah(id) ON DELETE CASCADE
);

-- Data dummy users (password: admin123 / user123)
INSERT INTO users (username, password, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('user', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

-- Data dummy mahasiswa
INSERT INTO mahasiswa (npm, nama_lengkap, fakultas, jurusan, tempat_lahir, tanggal_lahir, jenis_kelamin) VALUES
('20241001', 'Andi Saputra', 'FTI', 'Teknik Informatika', 'Jakarta', '2002-05-10', 'Laki-laki'),
('20241002', 'Budi Santoso', 'FTI', 'Sistem Informasi', 'Bandung', '2001-08-22', 'Laki-laki'),
('20241003', 'Citra Dewi', 'FTI', 'Teknik Informatika', 'Surabaya', '2003-01-15', 'Perempuan');

-- Data dummy mata kuliah
INSERT INTO mata_kuliah (kode_mk, nama_mk, sks) VALUES
('IF101', 'Pemrograman Web', 3),
('IF102', 'Basis Data', 3),
('IF103', 'Pemrograman Berorientasi Objek', 3);
