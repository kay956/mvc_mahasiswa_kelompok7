<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white text-center border-0 rounded-top-4">
                <h4 class="mb-0"><i class="bi bi-box-arrow-in-right"></i> Login SIMAK</h4>
            </div>
            <div class="card-body p-4">
                
                <?php $this->flash('error'); ?>
                <?php $this->flash('success'); ?>
                <?php $this->flash('info'); ?>
                
                <form method="POST" action="<?= BASEURL ?>/auth/login">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="username" class="form-control" required autofocus placeholder="admin / user">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control" required placeholder="admin123 / user123">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>
                </form>
                
                <div class="text-center mt-4">
                    <hr class="my-3">
                    <p class="text-muted mb-3">Atau login dengan</p>
                    <a href="<?= BASEURL ?>/google-auth/login" class="btn btn-outline-danger w-100">
                        <i class="bi bi-google"></i> Login dengan Google
                    </a>
                </div>
                
                <div class="alert alert-info mt-4 small">
                    <i class="bi bi-info-circle"></i> <strong>Demo Akun:</strong><br>
                    Admin: admin / admin123<br>
                    User: user / user123
                </div>
            </div>
        </div>
    </div>
</div>