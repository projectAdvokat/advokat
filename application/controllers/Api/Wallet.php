<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Wallet_Model', 'wallet');
        // $this->user_id = auth_user_id(); // misal ambil dari JWT/Auth
        $this->user_id = 1; // contoh hardcode dulu
    }
    // GET /api/wallet
    public function index() {
        $balance = $this->wallet->get_balance($this->user_id);
        api_response(true, $balance);
    }
    // GET /api/wallet/ledger?from=&to=
    public function ledger() {
        $from = $this->input->get('from');
        $to   = $this->input->get('to');
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
