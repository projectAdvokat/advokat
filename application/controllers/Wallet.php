<?php

class Wallet extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session'); // load session
        $this->load->model('Wallet_Model', 'wallet');
        $this->load->model('Wallet_Ledger_Model', 'wallet_ledger');
    }

    private function request($url)
    {
        // Request ke API
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return $result = json_decode($response, true);
    }

    public function index($user_id)
{
    $user_role = $this->session->userdata('user_role');

    // Ambil saldo wallet user
    $wallet = $this->request(base_url('api/wallet/' . $user_id));

    $data['wallet'] = $wallet;

    // $data['ledger'] = $ledger;
    $data['user_role'] = $user_role;

    $this->load->view('dashboard/wallet', $data);
}


}
