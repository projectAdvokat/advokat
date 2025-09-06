<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Wallet_Model', 'wallet');
        $this->load->helper('api');
        // $this->user_id = auth_user_id(); // misal ambil dari JWT/Auth
    }
    // GET /api/wallet
    public function index($user_id) {
        $balance = $this->wallet->get_balance($user_id);
        api_response(true, $balance);
    }

    public function create()
    {
        $data = json_decode($this->input->raw_input_stream, true);

        // Validasi input
        if (empty($data['user_id'])) {
            return api_response(false, [], 'User ID wajib diisi');
        }

        // Default balance = 0 kalau tidak dikirim
        $balance = isset($data['balance']) ? (int)$data['balance'] : 0;

        // Cek apakah user sudah punya wallet
        $existing = $this->wallet->get_balance($data['user_id']);
        if ($existing) {
            return api_response(false, $existing, 'Wallet sudah ada untuk user ini');
        }

        // Insert wallet
        $insert_data = [
            'user_id'    => $data['user_id'],
            'balance'    => $balance,
        ];

        $wallet_id = $this->wallet->insert($insert_data);

        if ($wallet_id) {
            $new_wallet = $this->wallet->get_by_id($wallet_id);
            return api_response(true, $new_wallet, 'Wallet berhasil dibuat');
        } else {
            return api_response(false, [], 'Gagal membuat wallet');
        }
    }

    // GET /api/wallet/ledger?from=&to=
    public function ledger($user_id) {
        $input = json_decode($this->input->raw_input_stream, true);
        
        $from = null;
        $to = null;

        if(empty($input)){
            $from = $input['from'];
            $to = $input['to'];
        } else {
        $from = $this->input->get('from');
        $to   = $this->input->get('to');
        }

        $rows = $this->wallet->get_ledger($this->user_id, $from, $to);
        api_response(true, $rows);
    }
    // POST /api/wallet/payout-request
    public function payout_request() {
        $amount = $this->input->post('amount');
        if ($amount <= 0) {
            api_response(false, null, 'Invalid amount');
            return;
        }

        // Insert ledger entry
        $this->wallet->add_ledger([
            'user_id' => $this->user_id,
            'ref_type' => 'payout',
            'amount' => -$amount,
            'description' => 'Payout request'
        ]);

        // Kurangi saldo
        $this->wallet->update_balance($this->user_id, -$amount);

        api_response(true, null, 'Payout request submitted');
    }

    // POST /api/wallet/payout/approve (Admin only)
    public function payout_approve($user_id) {
        $amount = $this->input->post('amount');

        $this->wallet->add_ledger([
            'user_id' => $user_id,
            'ref_type' => 'payout',
            'amount' => -$amount,
            'description' => 'Payout approved by admin'
        ]);

        $this->wallet->update_balance($user_id, -$amount);

        api_response(true, null, 'Payout approved');
    }
}
