<?php
class HomeController extends Controller {
    
    public function index() {
        $data['title'] = 'Welcome to SIMAK';
        $this->view('home/index', $data);
    }
    
}
?>