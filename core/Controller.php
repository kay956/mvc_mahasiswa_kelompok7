<?php
class Controller {
    protected function view($view, $data = []) {
        extract($data);
        
        // File view
        $viewFile = "../app/views/$view.php";
        
        if (!file_exists($viewFile)) {
            echo "<h3>Error: View '$view' tidak ditemukan</h3>";
            echo "<p>File yang dicari: $viewFile</p>";
            return;
        }
        
        // Layout header
        $headerFile = "../app/views/layouts/header.php";
        if (file_exists($headerFile)) {
            require_once $headerFile;
        }
        
        // Content
        require_once $viewFile;
        
        // Layout footer
        $footerFile = "../app/views/layouts/footer.php";
        if (file_exists($footerFile)) {
            require_once $footerFile;
        }
    }
    
    protected function model($model) {
        $modelFile = "../app/models/$model.php";
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $model();
        }
        echo "<h3>Error: Model '$model' tidak ditemukan</h3>";
        return null;
    }
    
    protected function setFlash($key, $message) {
        $_SESSION['flash'][$key] = $message;
    }
    
    protected function flash($key) {
        if (isset($_SESSION['flash'][$key])) {
            $alertType = ($key == 'success') ? 'success' : 'danger';
            echo '<div class="alert alert-' . $alertType . ' alert-dismissible fade show" role="alert">
                    ' . $_SESSION['flash'][$key] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>';
            unset($_SESSION['flash'][$key]);
        }
    }
    
    protected function formatTanggal($date) {
        if ($date && $date != '0000-00-00') {
            return date('d/m/Y', strtotime($date));
        }
        return '-';
    }
}
?>