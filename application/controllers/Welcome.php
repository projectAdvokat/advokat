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
        $lawyers = api_get('/api/lawyers?online=1&sort=online')['data'];
		$this->load->view('welcome_message', ['lawyers' => $lawyers]);


		// $users = $this->User_Model->get_all();

        // echo '<pre>';
        // print_r($users);
        // echo '</pre>';
	}
}
