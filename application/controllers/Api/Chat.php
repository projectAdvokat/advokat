<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Messages_Model', 'message');

        $this->load->library('session'); // load session
        
        $this->load->model('Chats_Model', 'chat');
    }
    public function index() {
         $booking_id = $this->input->get('booking_id');

         if (!$booking_id) {
            api_response(false, null, 'booking_id is required');
            return;
        }

        $messages = $this->message->get_messages_by_booking($booking_id);
        api_response(true, $messages);

 
    }
    public function create() {
        $data = json_decode($this->input->raw_input_stream, true);

        if (empty($data)) {
            api_response(false, null, 'No data provided');
            return;
        }

        $insert_id = $this->chat->insert($data);
        if ($insert_id) {
            api_response(true, ['id' => $insert_id], 'Chat Session create successfully');
        } else {
            api_response(false, null, 'Failed to create chat session');
        }
    }

    public function get_chat($chat_id)
    {
        $chat = $this->chat->get_by_id($chat_id);
        api_response(true, $chat);
    }

    public function send_messages($chat_id) {
         $sender_id    = $this->session->userdata('user_id'); // login user
        $text = $this->input->post('text');
        $this->message->insert([
            'chat_id' => $chat_id,
            'sender_id' => $sender_id,
            'text' => $text,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $chat_session = $this->chat->get_by_id($chat_id);
        if($sender_id ==  $chat_session['lawyer_id'] && $chat_session['start_time'] == null){
            
            $this->chat->update($chat_id, ['start_time' => date('Y-m-d H:i:s'),'end_time'=> date('Y-m-d H:i:s', strtotime($chat_session['duration_minutes'].'minutes'))]);

        }


        // api_response(true, null, 'message sent');


        
       
        // api_response(true, null, 'message sent');
    }
}
