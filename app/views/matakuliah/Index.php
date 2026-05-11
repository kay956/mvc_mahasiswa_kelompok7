<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Data Mata Kuliah</h4>
    </div>
    <div class="card-body">
        <?php $this->flash('success'); ?>
        <?php $this->flash('error'); ?>
        
        <a href="<?= BASEURL ?>/matakuliah/create" class="btn btn-primary mb-3">Tambah Mata Kuliah</a>
        
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr><th>No</th><th>Kode MK</th><th>Nama Mata Kuliah</th><th>SKS</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($matakuliah as $mk): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $mk['kode_mk'] ?></td>
                            <td><?= $mk['nama_mk'] ?></td>
                            <td><?= $mk['sks'] ?> SKS</td>
                            <td>
                                <a href="<?= BASEURL ?>/matakuliah/edit/<?= $mk['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?= BASEURL ?>/matakuliah/delete/<?= $mk['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>