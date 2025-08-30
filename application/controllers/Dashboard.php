<?php

class Dashboard extends CI_Controller {
    public function index() {
        $this->load->view('layouts/dashboard', ['content' => 'dashboard/index','title' => 'Dashboard']);
    }

    public function MyArticles(){
        // untuk edit page articles ada di /view/dashboard/my_articles.php
        $this->load->view('layouts/dashboard', ['content' => 'dashboard/my_articles','title' => 'My Articles']);

    }
}
