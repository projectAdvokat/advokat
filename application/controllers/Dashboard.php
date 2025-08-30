<?php

class Dashboard extends CI_Controller {
    public function index() {
        $this->load->view('dashboard/index');
    }

    public function MyArticles(){
        $this->load->view('dashboard/my_articles');

    }
}
