<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        // Load model User_model
        $this->load->model('User_Model');
    }

	public function index()
	{
		$this->load->view('welcome_message');

		// $users = $this->User_Model->get_all();

        // echo '<pre>';
        // print_r($users);
        // echo '</pre>';
	}
}
