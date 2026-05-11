<div class="row justify-content-center">
    <div class="col-md-10">
        <!-- Hero Section -->
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="card-body text-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h1 class="display-3 fw-bold text-white mb-3">
                    <i class="bi bi-mortarboard"></i> SIMAK
                </h1>
                <p class="lead text-white-50 mb-4">Sistem Informasi Manajemen Akademik</p>
                <p class="text-white mb-4">Kelola data mahasiswa, mata kuliah, dan nilai dengan mudah</p>
                <b>
                <p class="text-white mb-4">Kelas 6C</p>
                <p class="text-white mb-4">Kayla Alifa Inayah 2310010224</p>
                <p class="text-white mb-4">Assyifa Nur Aulia 2310010409</p></b>
                
                <?php if(!isset($_SESSION['user'])): ?>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="<?= BASEURL ?>/auth/login" class="btn btn-light btn-lg px-4">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                        <a href="<?= BASEURL ?>/google-auth/login" class="btn btn-danger btn-lg px-4">
                            <i class="bi bi-google"></i> Login with Google
                        </a>
                    </div>
                <?php else: ?>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="<?= BASEURL ?>/mahasiswa" class="btn btn-light btn-lg px-4">
                            <i class="bi bi-arrow-right"></i> Masuk ke Dashboard
                        </a>
                        <a href="<?= BASEURL ?>/auth/logout" class="btn btn-outline-light btn-lg px-4">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Fitur Section -->
        <div class="row mt-5 g-4">
            <div class="col-md-4">
                <div class="card h-100 text-center shadow-sm">
                    <div class="card-body">
                        <div class="display-1 text-primary">
                            <i class="bi bi-people"></i>
                        </div>
                        <h5 class="card-title mt-3">Data Mahasiswa</h5>
                        <p class="card-text text-muted">Kelola data mahasiswa, lengkap dengan CRUD, search, dan filter</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center shadow-sm">
                    <div class="card-body">
                        <div class="display-1 text-success">
                            <i class="bi bi-journal-bookmark-fill"></i>
                        </div>
                        <h5 class="card-title mt-3">Mata Kuliah</h5>
                        <p class="card-text text-muted">Manajemen mata kuliah dan relasi dengan mahasiswa</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center shadow-sm">
                    <div class="card-body">
                        <div class="display-1 text-info">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </div>
                        <h5 class="card-title mt-3">Export Laporan</h5>
                        <p class="card-text text-muted">Export data ke CSV dan PDF untuk laporan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>