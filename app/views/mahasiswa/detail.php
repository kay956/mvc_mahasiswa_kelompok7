<div class="card shadow mb-4">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="bi bi-person-badge"></i> Detail Mahasiswa</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="200">NPM</th>
                <td><?= htmlspecialchars($m['npm']) ?></td>
            </tr>
            <tr>
                <th>Nama Lengkap</th>
                <td><?= htmlspecialchars($m['nama_lengkap']) ?></td>
            </tr>
            <tr>
                <th>Fakultas</th>
                <td><?= htmlspecialchars($m['fakultas'] ?: '-') ?></td>
            </tr>
            <tr>
                <th>Jurusan</th>
                <td><?= htmlspecialchars($m['jurusan']) ?></td>
            </tr>
            <tr>
                <th>Tempat Lahir</th>
                <td><?= htmlspecialchars($m['tempat_lahir'] ?: '-') ?></td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td><?= $this->formatTanggal($m['tanggal_lahir']) ?></td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td><?= htmlspecialchars($m['jenis_kelamin']) ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <?php if($m['status_id'] == 1): ?>
                        <span class="badge bg-success">Aktif</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Nonaktif</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
        <a href="<?= BASEURL ?>/mahasiswa" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-header bg-success text-white">
        <h4 class="mb-0"><i class="bi bi-journal-bookmark-fill"></i> Mata Kuliah yang Diambil</h4>
    </div>
    <div class="card-body">
        
        <?php $this->flash('success'); ?>
        <?php $this->flash('error'); ?>
        
        <!-- Form Tambah Mata Kuliah (hanya untuk admin) -->
        <?php if(isset($isAdmin) && $isAdmin): ?>
        <form method="POST" action="<?= BASEURL ?>/mahasiswa/tambahMataKuliah" class="row g-3 mb-4 border p-3 rounded">
            <input type="hidden" name="mahasiswa_id" value="<?= $m['id'] ?>">
            <div class="col-md-6">
                <label class="form-label">Pilih Mata Kuliah</label>
                <select name="mata_kuliah_id" class="form-select" required>
                    <option value="">-- Pilih Mata Kuliah --</option>
                    <?php foreach($semua_matakuliah as $mk): ?>
                        <option value="<?= $mk['id'] ?>">
                            <?= htmlspecialchars($mk['kode_mk']) ?> - <?= htmlspecialchars($mk['nama_mk']) ?> (<?= $mk['sks'] ?> SKS)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Nilai (Opsional)</label>
                <select name="nilai" class="form-select">
                    <option value="">-- Pilih Nilai --</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-plus-circle"></i> Tambah Mata Kuliah
                </button>
            </div>
        </form>
        <?php endif; ?>
        
        <!-- Tabel Mata Kuliah yang Diambil -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode MK</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Nilai</th>
                        <?php if(isset($isAdmin) && $isAdmin): ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($matakuliah_diambil)): ?>
                        <tr>
                            <td colspan="<?= (isset($isAdmin) && $isAdmin) ? '6' : '5' ?>" class="text-center">
                                <i class="bi bi-info-circle"></i> Belum ada mata kuliah yang diambil
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach($matakuliah_diambil as $mk): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($mk['kode_mk']) ?></td>
                                <td><?= htmlspecialchars($mk['nama_mk']) ?></td>
                                <td><?= $mk['sks'] ?> SKS</td>
                                <td>
                                    <?php if($mk['nilai']): ?>
                                        <span class="badge bg-info"><?= htmlspecialchars($mk['nilai']) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <?php if(isset($isAdmin) && $isAdmin): ?>
                                    <td>
                                        <a href="<?= BASEURL ?>/mahasiswa/hapusMataKuliah/<?= $mk['ambil_id'] ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Yakin ingin menghapus mata kuliah ini?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Total SKS -->
        <?php 
        $total_sks = 0;
        foreach($matakuliah_diambil as $mk) {
            $total_sks += $mk['sks'];
        }
        ?>
        <?php if($total_sks > 0): ?>
            <div class="alert alert-info mt-3">
                <i class="bi bi-calculator"></i> <strong>Total SKS yang diambil: <?= $total_sks ?> SKS</strong>
            </div>
        <?php endif; ?>
    </div>
</div>