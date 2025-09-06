<?php
use Xendit\Configuration;
use Xendit\Payout\PayoutApi;
use Xendit\Payout\CreatePayoutRequest;

class Payout extends CI_Controller {


    public function __construct() {
        parent::__construct();
    
        $this->load->model('Wallet_Model', 'wallet');

        $this->load->library('session'); // load session
         $this->load->helper('env');
        if (function_exists('load_dotenv')) {
            load_dotenv();
        }
        
        // Load config midtrans
        $this->config->load('midtrans');
        $this->load->model('Commission_Model', 'commission');
    }

    public function withdraw() {
        $amount         = (int) $this->input->post('amount');
        $bank           = $this->input->post('bank');
        $accountNumber  = $this->input->post('accountNumber');
        $accountName    = $this->input->post('accountName');
        $email          = $this->input->post('email');
        $user_id        = $this->session->userdata('user_id');

        // Cek saldo cukup
        $balance =  (int) $this->wallet->get_balance($user_id)['balance'];
        if ($balance < $amount) {
            return $this->output->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode(['error' => 'Saldo tidak cukup']));
        }

        // Kurangi saldo dulu
        $this->wallet->deduct_balance($user_id, $amount);

        // Setup Xendit
        Configuration::setXenditKey($_ENV['XENDIT_API_KEY']);
        $apiInstance = new PayoutApi();
        $idempotency_key = 'WD-' . uniqid();

        $channel_map = [
            'bca' => 'ID_BCA',
            'bni' => 'ID_BNI',
            'mandiri' => 'ID_MANDIRI'
        ];
        $channel_code = $channel_map[$bank] ?? null;

        if (!$channel_code) {
            return $this->output->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode(['error' => 'Bank tidak valid']));
        }

        $create_payout_request = new CreatePayoutRequest([
            'reference_id' => 'withdraw-' . $user_id . '-' . time(),
            'currency' => 'IDR',
            'channel_code' => $channel_code,
            'channel_properties' => [
                'account_holder_name' => $accountName,
                'account_number' => $accountNumber
            ],
            'amount' => $amount,
            'description' => 'Withdraw user ' . $user_id,
            'receipt_notification' => [
                'email_to' => [$email]
            ]
        ]);

        try {
            $result = $apiInstance->createPayout($idempotency_key, null, $create_payout_request);

            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => true, 'data' => $result]));

        } catch (\Xendit\XenditSdkException $e) {
            // Kalau gagal, saldo dikembalikan
            $this->wallet->add_balance($user_id, $amount);

            return $this->output->set_content_type('application/json')
                ->set_status_header(500)
                ->set_output(json_encode([
                    'error' => $e->getMessage(),
                    'details' => $e->getFullError()
                ]));
        }
    }

       // Webhook
    public function xendit_payout_webhook() {
        $raw_input = file_get_contents("php://input");
        $webhook_data = json_decode($raw_input, true);

        $callback_token = $this->config->item('xendit_callback_token');
        $xendit_signature = $_SERVER['HTTP_X_CALLBACK_TOKEN'] ?? '';

        if ($callback_token && $xendit_signature !== $callback_token) {
            http_response_code(403);
            echo 'Invalid callback token';
            return;
        }

        $status = $webhook_data['status']; // PENDING, COMPLETED, FAILED
        $amount = $webhook_data['amount'];
        $reference_id = $webhook_data['reference_id']; 
        // contoh: withdraw-5-172534534

        // Ambil user_id dari reference_id
        $parts = explode('-', $reference_id);
        $user_id = $parts[1] ?? null;

        if ($status === 'FAILED' && $user_id) {
            // saldo dikembalikan
            $this->wallet->update_balance($user_id, $amount);
        }

        http_response_code(200);
        echo 'Webhook processed';
    }

}
