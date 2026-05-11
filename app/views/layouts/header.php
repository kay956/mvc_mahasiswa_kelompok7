<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SIMAK - Sistem Informasi Manajemen Akademik' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .avatar-sm {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="<?= BASEURL ?>">
    <i class="bi bi-mortarboard"></i> SIMAK
</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if(isset($_SESSION['user'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASEURL ?>/dashboard">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASEURL ?>/mahasiswa">
                                <i class="bi bi-people"></i> Mahasiswa
                            </a>
                        </li>
                        <?php if($_SESSION['user']['role'] == 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASEURL ?>/matakuliah">
                                    <i class="bi bi-journal-bookmark-fill"></i> Mata Kuliah
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                                <?php if(isset($_SESSION['user']['avatar'])): ?>
                                    <img src="<?= $_SESSION['user']['avatar'] ?>" class="avatar-sm">
                                <?php else: ?>
                                    <i class="bi bi-person-circle fs-5"></i>
                                <?php endif; ?>
                                <span><?= $_SESSION['user']['name'] ?? $_SESSION['user']['username'] ?></span>
                                <span class="badge bg-light text-dark"><?= $_SESSION['user']['role'] ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?= BASEURL ?>/auth/logout">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASEURL ?>/auth/login">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        <div class="container">