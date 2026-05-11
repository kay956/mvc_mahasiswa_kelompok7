<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Tambah Mahasiswa</h4>
    </div>
    <div class="card-body">
        
        <?php $this->flash('error'); ?>
        
        <form method="POST" action="<?= BASEURL ?>/mahasiswa/store">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>NPM <span class="text-danger">*</span></label>
                    <input type="text" name="npm" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Fakultas</label>
                    <input type="text" name="fakultas" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Jurusan <span class="text-danger">*</span></label>
                    <select name="jurusan" class="form-select" required>
                        <option value="">Pilih</option>
                        <option value="Teknik Informatika">Teknik Informatika</option>
                        <option value="Sistem Informasi">Sistem Informasi</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Jenis Kelamin <span class="text-danger">*</span></label><br>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="jenis_kelamin" value="Laki-laki" class="form-check-input" required> Laki-laki
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="jenis_kelamin" value="Perempuan" class="form-check-input" required> Perempuan
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= BASEURL ?>/mahasiswa" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>