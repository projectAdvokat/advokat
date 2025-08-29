<?php

class ChatPage extends CI_Controller {

      public function __construct()
    {
        parent::__construct();
        $this->load->library('session'); // load session
    }
    

    public function index($booking_id) {
        
        $this->load->view('chat/index');
    }

}