<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_Model', 'user'); // pastikan model user ada
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('auth/login');
        }

        $data['user'] = $this->user->get_by_id($user_id);

        $this->load->view('dashboard/profile', $data);
    }

}