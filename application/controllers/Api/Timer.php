<?php

class Timer extends CI_Controller {

    

   public function chatTimer($chat_id) {
        $this->load->model('Chats_Model', 'chat');
        $chat = $this->chat->get_by_id($chat_id);
        if (!$chat) {
            show_404();
        }

        $this->load->view('timer/index', ['chat' => $chat]);
    }

      public function __construct()
    {
        parent::__construct();
        $this->load->library('session'); // load session
    }
    public function register() {
        $this->load->view('auth/register');
    }
}