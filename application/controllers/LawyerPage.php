<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LawyerPage extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session'); // load session
        
    }
    
    public function index()
    {
         $lawyers = api_get('/api/lawyers?online=1&sort=online')['data'];
		
         $this->load->view('lawyer/list', ['lawyers' => $lawyers]);
  
    }

    public function booking($lawyer_id)

    {
        $lawyer = api_get('/api/lawyer/show/'.$lawyer_id);
        
        $this->load->view('lawyer/booking', ['lawyer' => $lawyer['data']]);

    }
}
