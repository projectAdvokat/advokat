<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        // Load model User_model
        $this->load->model('User_Model');
        $this->load->model('Article_Model','Articles');
        $this->load->library('session'); // load session
        
    }


	public function index()
	{
        $lawyers = api_get('/api/lawyers?online=1&sort=online')['data'];
        $latest_articles = $this->Articles->get_latest(3);
		$this->load->view('welcome_message', ['lawyers' => $lawyers, 'latest_articles' => $latest_articles]);


		// $users = $this->User_Model->get_all();

        // echo '<pre>';
        // print_r($users);
        // echo '</pre>';
	}
}
