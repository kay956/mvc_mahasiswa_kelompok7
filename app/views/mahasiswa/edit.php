<div class="card shadow">
    <div class="card-header bg-warning">
        <h4 class="mb-0">Edit Mahasiswa</h4>
    </div>
    <div class="card-body">
        
        <?php $this->flash('error'); ?>
        
        <form method="POST" action="<?= BASEURL ?>/mahasiswa/update/<?= $m['id'] ?>">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>NPM <span class="text-danger">*</span></label>
                    <input type="text" name="npm" class="form-control" value="<?= htmlspecialchars($m['npm']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" class="form-control" value="<?= htmlspecialchars($m['nama_lengkap']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Fakultas</label>
                    <input type="text" name="fakultas" class="form-control" value="<?= htmlspecialchars($m['fakultas']) ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Jurusan <span class="text-danger">*</span></label>
                    <select name="jurusan" class="form-select" required>
                        <option value="Teknik Informatika" <?= $m['jurusan']=='Teknik Informatika' ? 'selected' : '' ?>>Teknik Informatika</option>
                        <option value="Sistem Informasi" <?= $m['jurusan']=='Sistem Informasi' ? 'selected' : '' ?>>Sistem Informasi</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" value="<?= htmlspecialchars($m['tempat_lahir']) ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="<?= $m['tanggal_lahir'] ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Jenis Kelamin <span class="text-danger">*</span></label><br>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="jenis_kelamin" value="Laki-laki" <?= $m['jenis_kelamin']=='Laki-laki' ? 'checked' : '' ?> class="form-check-input" required> Laki-laki
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="jenis_kelamin" value="Perempuan" <?= $m['jenis_kelamin']=='Perempuan' ? 'checked' : '' ?> class="form-check-input" required> Perempuan
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?= BASEURL ?>/mahasiswa" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>