<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h2>
    </div>
    
    <!-- Card Ringkasan -->
    <div class="col-md-3">
        <div class="card bg-primary text-white mb-4 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Mahasiswa</h6>
                        <h2 class="mb-0"><?= $total_mahasiswa ?></h2>
                    </div>
                    <i class="bi bi-people fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-success text-white mb-4 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Mata Kuliah</h6>
                        <h2 class="mb-0"><?= $total_matakuliah ?></h2>
                    </div>
                    <i class="bi bi-journal-bookmark-fill fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-info text-white mb-4 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Mahasiswa Aktif</h6>
                        <h2 class="mb-0"><?= $status_stats[0]['total'] ?></h2>
                    </div>
                    <i class="bi bi-check-circle fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-warning text-white mb-4 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Mahasiswa Nonaktif</h6>
                        <h2 class="mb-0"><?= $status_stats[1]['total'] ?></h2>
                    </div>
                    <i class="bi bi-x-circle fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Grafik Jurusan (Bar Chart) -->
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Statistik Mahasiswa per Jurusan</h5>
            </div>
            <div class="card-body">
                <canvas id="jurusanChart" height="250"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Grafik Status (Pie Chart) -->
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-graph-up"></i> Status Mahasiswa</h5>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Grafik Fakultas (Bar Chart) -->
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-building"></i> Mahasiswa per Fakultas</h5>
            </div>
            <div class="card-body">
                <canvas id="fakultasChart" height="250"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Grafik Jenis Kelamin (Doughnut Chart) -->
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-gender-ambiguous"></i> Jenis Kelamin</h5>
            </div>
            <div class="card-body">
                <canvas id="genderChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Mahasiswa Terbaru -->
<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> 5 Mahasiswa Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>NPM</th>
                                <th>Nama Lengkap</th>
                                <th>Jurusan</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($mahasiswa_terbaru)): ?>
                                <tr><td colspan="6" class="text-center">Belum ada data</td></tr>
                            <?php else: ?>
                                <?php $no=1; foreach($mahasiswa_terbaru as $m): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($m['npm']) ?></td>
                                        <td><?= htmlspecialchars($m['nama_lengkap']) ?></td>
                                        <td><?= htmlspecialchars($m['jurusan']) ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($m['created_at'])) ?></td>
                                        <td>
                                            <a href="<?= BASEURL ?>/mahasiswa/detail/<?= $m['id'] ?>" class="btn btn-sm btn-info">Detail</a>
                                         </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// Grafik Jurusan
const jurusanCtx = document.getElementById('jurusanChart').getContext('2d');
const jurusanData = <?= json_encode($jurusan_stats) ?>;
new Chart(jurusanCtx, {
    type: 'bar',
    data: {
        labels: jurusanData.map(item => item.jurusan || 'Tidak diisi'),
        datasets: [{
            label: 'Jumlah Mahasiswa',
            data: jurusanData.map(item => item.total),
            backgroundColor: ['#4CAF50', '#2196F3', '#FF9800'],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { position: 'top' }
        }
    }
});

// Grafik Status (Pie)
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusData = <?= json_encode($status_stats) ?>;
new Chart(statusCtx, {
    type: 'pie',
    data: {
        labels: statusData.map(item => item.label),
        datasets: [{
            data: statusData.map(item => item.total),
            backgroundColor: ['#4CAF50', '#f44336'],
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' }
        }
    }
});

// Grafik Fakultas
const fakultasCtx = document.getElementById('fakultasChart').getContext('2d');
const fakultasData = <?= json_encode($fakultas_stats) ?>;
new Chart(fakultasCtx, {
    type: 'bar',
    data: {
        labels: fakultasData.map(item => item.fakultas || 'Tidak diisi'),
        datasets: [{
            label: 'Jumlah Mahasiswa',
            data: fakultasData.map(item => item.total),
            backgroundColor: '#FF9800',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true
    }
});

// Grafik Jenis Kelamin (Doughnut)
const genderCtx = document.getElementById('genderChart').getContext('2d');
const genderData = <?= json_encode($gender_stats) ?>;
new Chart(genderCtx, {
    type: 'doughnut',
    data: {
        labels: genderData.map(item => item.label),
        datasets: [{
            data: genderData.map(item => item.total),
            backgroundColor: ['#2196F3', '#E91E63'],
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' }
        }
    }
});
</script>

<style>
    .card {
        border-radius: 10px;
        border: none;
    }
    .card-header {
        border-bottom: 1px solid #e3e6f0;
        background-color: #f8f9fc;
    }
</style>