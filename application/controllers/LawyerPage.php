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
         $client_id = $this->session->userdata('user_id');
        $current_booking_lawyer = api_get('Api/booking/get_by_client/'.$client_id)['data'];
         $this->load->view('lawyer/list', ['lawyers' => $lawyers,'current_booking_lawyer'=>$current_booking_lawyer]);
  
    }

    public function booking($lawyer_id)

    {
        $this->load->model('Lawyer_Model', 'lawyers');
        $lawyer = $this->lawyers->get_by_id($lawyer_id);
        // $lawyer = api_get('/api/lawyer/show/'.$lawyer_id);

        
        $this->load->view('lawyer/booking', ['lawyer' => $lawyer]);

    }
}
