<?php

class AuthPage extends CI_Controller {

      public function __construct()
    {
        parent::__construct();
        $this->load->library('session'); // load session
    }
    

    public function login() {
        
        $this->load->view('auth/login');
    }

    public function register() {
        $this->load->view('auth/register');
    }
}