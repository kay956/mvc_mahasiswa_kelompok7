<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="bi bi-table"></i> Data Mahasiswa</h4>
    </div>
    <div class="card-body">
        
        <?php $this->flash('success'); ?>
        <?php $this->flash('error'); ?>
        
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" 
                       placeholder="Cari NPM/Nama" value="<?= htmlspecialchars($search ?? '') ?>">
            </div>
            <div class="col-md-3">
                <select name="jurusan" class="form-select">
                    <option value="">Semua Jurusan</option>
                    <option value="Teknik Informatika" <?= ($jurusanFilter ?? '') == 'Teknik Informatika' ? 'selected' : '' ?>>Teknik Informatika</option>
                    <option value="Sistem Informasi" <?= ($jurusanFilter ?? '') == 'Sistem Informasi' ? 'selected' : '' ?>>Sistem Informasi</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Cari</button>
            </div>
            <div class="col-md-3">
                <a href="<?= BASEURL ?>/mahasiswa" class="btn btn-secondary w-100"><i class="bi bi-arrow-repeat"></i> Reset</a>
            </div>
        </form>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>NPM</th>
                        <th>Nama Lengkap</th>
                        <th>Fakultas</th>
                        <th>Jurusan</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($mahasiswa)): ?>
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php else: ?>
                        <?php $no=1; foreach($mahasiswa as $m): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($m['npm']) ?></td>
                            <td><?= htmlspecialchars($m['nama_lengkap']) ?></td>
                            <td><?= htmlspecialchars($m['fakultas']) ?></td>
                            <td><?= htmlspecialchars($m['jurusan']) ?></td>
                            <td><?= htmlspecialchars($m['tempat_lahir']) ?></td>
                            <td><?= $this->formatTanggal($m['tanggal_lahir']) ?></td>
                            <td><?= htmlspecialchars($m['jenis_kelamin']) ?></td>
                            <td><?= $m['status_id']==1 ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Nonaktif</span>' ?></td>
                            <td>
                                <!-- Tombol Detail untuk semua user -->
                                <a href="<?= BASEURL ?>/mahasiswa/detail/<?= $m['id'] ?>" class="btn btn-info btn-sm">Detail</a>
                                
                                <!-- Tombol Edit & Hapus hanya untuk admin -->
                                <?php if($isAdmin): ?>
                                    <a href="<?= BASEURL ?>/mahasiswa/edit/<?= $m['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="<?= BASEURL ?>/mahasiswa/delete/<?= $m['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            <a href="<?= BASEURL ?>/mahasiswa/exportCSV?search=<?= urlencode($search??'') ?>&jurusan=<?= urlencode($jurusanFilter??'') ?>" class="btn btn-success">Export CSV</a>
            <a href="<?= BASEURL ?>/mahasiswa/exportPDF?search=<?= urlencode($search??'') ?>&jurusan=<?= urlencode($jurusanFilter??'') ?>" class="btn btn-danger">Export PDF</a>
            <?php if($isAdmin): ?>
                <a href="<?= BASEURL ?>/mahasiswa/create" class="btn btn-primary float-end">Tambah Mahasiswa</a>
            <?php endif; ?>
        </div>
    </div>
</div>