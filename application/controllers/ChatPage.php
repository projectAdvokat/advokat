<?php

class ChatPage extends CI_Controller {

      public function __construct()
    {
        parent::__construct();
        $this->load->library('session'); // load session
    }
    

    public function index($booking_id) {
        $chats = api_get('/api/chat?booking_id='.$booking_id)['data'];
        $count = count($chats);
        


        
        $this->load->view('chat/index', ['chats' => $chats, 'booking_id' => $booking_id , 'count' => $count]);
    }

}