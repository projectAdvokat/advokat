<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Messages_Model', 'message');
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

    public function messages() {
        
       
        // api_response(true, null, 'message sent');
    }
}
