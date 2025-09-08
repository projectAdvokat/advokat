<?php

class ChatPage extends CI_Controller {

      public function __construct()
    {
        parent::__construct();
        $this->load->library('session'); // load session
    }
    

    public function index($booking_id) {
        $chats = api_get('api/chats?booking_id='.$booking_id)['data'];
        $count = 0;
        // $chat_id = $chats->chat->id;

        


        
        $this->load->view('chat/index', ['chats' => $chats, 'booking_id' => $booking_id , 'count' => $count]);
    }

    public function client_chats() {
     $this->load->helper('api');

        $user_id   = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('user_role');

        // hanya lawyer yang bisa akses
        if (!$user_id || $user_role !== 'client') {
            $this->session->set_flashdata('error', 'Hanya klien yang bisa mengakses roomchat.');
            redirect('/');
            return;
        }

        // kirim request ke API
        $url = base_url('Api/Chat/my_chats');

    // CURL ke API
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['user_role' => $user_role, 'user_id' => $user_id]));

    $result = curl_exec($ch);

    if ($result === false) {
        $error = curl_error($ch);
        curl_close($ch);
        show_error("Curl Error: " . $error);
        return;
    }

    curl_close($ch);

    $response = json_decode($result, true);

        $data['chats'] = [];
        if ($response && isset($response['ok']) && $response['ok'] === true) {
            $data['chats'] = $response['data'];
        } else {
            $data['error'] = isset($response['message']) ? $response['message'] : 'Gagal mengambil data chat.';
        }

        $this->load->view('client/chat', [ 'chats' => $data['chats']]);
    }

}