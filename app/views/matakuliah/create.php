<div class="card shadow">
    <div class="card-header bg-primary text-white"><h4>Tambah Mata Kuliah</h4></div>
    <div class="card-body">
        <form method="POST" action="<?= BASEURL ?>/matakuliah/store">
            <div class="mb-3"><label>Kode MK</label><input type="text" name="kode_mk" class="form-control" required></div>
            <div class="mb-3"><label>Nama Mata Kuliah</label><input type="text" name="nama_mk" class="form-control" required></div>
            <div class="mb-3"><label>SKS</label><input type="number" name="sks" class="form-control" value="3"></div>
            <button class="btn btn-primary">Simpan</button>
            <a href="<?= BASEURL ?>/matakuliah" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>