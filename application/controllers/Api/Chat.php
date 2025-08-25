<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Messages_Model', 'message');
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

    public function messages() {
        
       
        // api_response(true, null, 'message sent');
    }
}
