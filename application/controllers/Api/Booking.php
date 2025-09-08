<?php
use Midtrans\Config;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\Invoice;
use Midtrans\Snap;
use Midtrans\Notification;

class Booking extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Booking_Model', 'booking');
        $this->load->model('Chats_Model', 'chat_model');
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

    public function index() {
        $bookings = $this->booking->get_all();
        api_response(true, $bookings);
    }

    public function view($id) {
        $booking = $this->booking->get_by_id($id);
        if ($booking) {
            api_response(true, $booking);
        } else {
            api_response(false, null, 'Booking not found');
        }
    }

    public function create() {
                 header('Content-Type: application/json');

        // baca body JSON dari fetch()
        $data = json_decode($this->input->raw_input_stream, true);


            if (empty($data)) {
            api_response(false, null, 'No data provided');
            return;
        }

        $insert_id = $this->booking->insert($data);
        if ($insert_id) {
            api_response(true, ['id' => $insert_id], 'Booking created successfully');
        } else {
            api_response(false, null, 'Failed to create booking');
        }
    }

    public function update($id) {
        $data = $this->input->post();
        if (empty($data)) {
            api_response(false, null, 'No data provided');
            return;
        }


    

        $updated = $this->booking->update($id, $data);
        if ($updated) {
            api_response(true, null, 'Booking updated successfully');
        } else {
            api_response(false, null, 'Failed to update booking');
        }
    }

    public function delete($id) {
        
        $deleted = $this->booking->delete($id);
        if ($deleted) {
            api_response(true, null, 'Booking deleted successfully');
        } else {
            api_response(false, null, 'Failed to delete booking');
        }


    
    }


    public function updateStatus() {

        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $updated = $this->booking->updateStatus($id, $status);
        if ($updated) {
            api_response(true, null, 'Booking status updated successfully');
        } else {
            api_response(false, null, 'Failed to update booking status');
        }
    }

    public function get_by_client($id) {
        // $client_id = $this->session->userdata('user_id'); // user login
        //  if (!$client_id) {
        //     api_response(false, null, 'Unauthorized');
        //     return;
        // }
        $bookings = $this->booking->get_by_client($id);
        api_response(true, $bookings);
    }

    // pay with xendit (with library)
//     public function pay($lawyer_id) {
//     $this->load->model('Lawyer_Model', 'lawyer');
//     header('Content-Type: application/json');

//     // baca body JSON dari fetch()
//     $data = json_decode($this->input->raw_input_stream, true);

//     if (!$lawyer_id || empty($data['duration'])) {
//         echo json_encode([
//             'status' => 'error',
//             'message' => 'Lawyer ID dan durasi harus diisi'
//         ]);
//         return;
//     }

//     $lawyer =  $this->lawyer->get_by_id($lawyer_id);
//     $quantity = ceil($data['duration'] / 30); 
//     $price = intval($lawyer['price_30m']);
//     $total = $price * $quantity;

//     // Set Xendit API Key
//     Configuration::setXenditKey($_ENV['XENDIT_API_KEY']);

//     try {
//         $params = [
//             'external_id' => 'booking-' . time() . '-' . $lawyer_id . '-' . $this->session->userdata('user_id'),
//             'payer_email' => $this->session->userdata('user_email') ?? 'customer@example.com',
//             'description' => 'Konsultasi Hukum dengan ' . $lawyer['name'] . ' (' . $data['duration'] . ' menit)',
//             'amount' => $total,
//             'success_redirect_url' => base_url('booking/success'),
//             'failure_redirect_url' => base_url('booking/failure'),
//             'currency' => 'IDR',
//             'items' => [
//                 [
//                     'name' => 'Konsultasi Hukum ' . $data['duration'] . ' menit',
//                     'quantity' => $quantity,
//                     'price' => $price,
//                     'category' => 'Legal Services'
//                 ]
//             ]
//         ];

//         $apiInstance = new InvoiceApi();
//         $create_invoice_request = new Xendit\Invoice\CreateInvoiceRequest($params);
//         $invoice = $apiInstance->createInvoice($create_invoice_request);

//         $this->booking->insert([
//     'client_id' => $this->session->userdata('user_id'),
//     'lawyer_id' => $lawyer_id,
//     'duration_minutes' => $data['duration'],
//     'price_snapshot' => $total,
//     'pg_ref' => $invoice['id'], // simpan di pg_ref
//     'status' => 'pending',
//     'created_at' => date('Y-m-d H:i:s')
// ]); 
        

//         echo json_encode([
//             'status' => 'success',
//             'message' => 'Invoice berhasil dibuat',
//             'data' => [
//                 'invoice_url' => $invoice['invoice_url']
//             ]
//         ]);
        
//     } catch (Exception $e) {
//         error_log('Xendit Error: ' . $e->getMessage());
//         echo json_encode([
//             'status' => 'error',
//             'message' => 'Terjadi kesalahan saat membuat invoice: ' . $e->getMessage()
//         ]);
//     }
// }
    // pay with xendit (without lib)
    public function pay($lawyer_id)
{
    $this->load->model('Lawyer_Model', 'lawyer');
    header('Content-Type: application/json');

    $data = json_decode($this->input->raw_input_stream, true);

    if (!$lawyer_id || empty($data['duration'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Lawyer ID dan durasi harus diisi'
        ]);
        return;
    }

    $lawyer   = $this->lawyer->get_by_id($lawyer_id);
    $quantity = ceil($data['duration'] / 30);
    $price    = intval($lawyer['price_30m']);
    $total    = $price * $quantity;

    // API Key Xendit
    $apiKey = $_ENV['XENDIT_API_KEY'] ?? 'xnd_development_xxx'; // ganti sesuai punya kamu

    // Invoice params
    $params = [
        'external_id' => 'booking-' . time() . '-' . $lawyer_id . '-' . $this->session->userdata('user_id'),
        'payer_email' => $this->session->userdata('user_email') ?? 'customer@example.com',
        'description' => 'Konsultasi Hukum dengan ' . $lawyer['name'] . ' (' . $data['duration'] . ' menit)',
        'amount'      => $total,
        'success_redirect_url' => base_url('booking/success'),
        'failure_redirect_url' => base_url('booking/failure'),
        'currency'    => 'IDR',
        'items' => [[
            'name'     => 'Konsultasi Hukum ' . $data['duration'] . ' menit',
            'quantity' => $quantity,
            'price'    => $price,
            'category' => 'Legal Services'
        ]]
    ];

    // Request ke Xendit API
    $ch = curl_init('https://api.xendit.co/v2/invoices');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ":");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $invoice = json_decode($response, true);

    if ($httpcode == 200 || $httpcode == 201) {
        // simpan ke DB booking
        $this->booking->insert([
            'client_id'       => $this->session->userdata('user_id'),
            'lawyer_id'       => $lawyer_id,
            'duration_minutes'=> $data['duration'],
            'price_snapshot'  => $total,
            'pg_ref'          => $invoice['id'],
            'status'          => 'pending',
            'created_at'      => date('Y-m-d H:i:s')
        ]);

        echo json_encode([
            'status'  => 'success',
            'message' => 'Invoice berhasil dibuat',
            'data'    => [
                'invoice_url' => $invoice['invoice_url']
            ]
        ]);
    } else {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal membuat invoice',
            'response'=> $invoice
        ]);
    }
}


// Webhook handler untuk Xendit (PENTING!)
public function xendit_webhook() {
    $this->load->model('Referral_Config_Model', 'referral_config');
    $this->load->model('User_Model', 'user');
    // $this->load->model('Commisions_Model', 'commisions');
    $this->load->model('Wallet_Model', 'wallet');
    $this->load->model('Booking_Model', 'booking');
    $this->load->model('Chat_Model', 'chat_model');

    $raw_input = file_get_contents("php://input");
    $webhook_data = json_decode($raw_input, true);

    // ✅ Verifikasi callback token
    $callback_token   = $_ENV['XENDIT_CALLBACK_TOKEN'] ?? '';
    $xendit_signature = $_SERVER['HTTP_X_CALLBACK_TOKEN'] ?? '';

    if ($callback_token && $xendit_signature !== $callback_token) {
        http_response_code(403);
        echo json_encode(['status' => 'error', 'message' => 'Invalid callback token']);
        return;
    }

    if (empty($webhook_data['id'])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'No invoice ID']);
        return;
    }

    $invoice_id = $webhook_data['id'];

    // ✅ Ambil detail invoice langsung dari Xendit API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.xendit.co/v2/invoices/" . $invoice_id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, $_ENV['XENDIT_API_KEY'] . ":");
    $result = curl_exec($ch);
    curl_close($ch);

    $invoice = json_decode($result, true);

    // if (!$invoice || !isset($invoice['status']) || $invoice['status'] !== 'PAID') {
    //     http_response_code(200);
    //     echo json_encode(['status' => 'ignored', 'message' => 'Invoice not paid']);
    //     return;
    // }


    // =========
// INVOICE WEBHOOK HANDLER
    // =======

    if(isset($webhook_data['id']) && isset($webhook_data['status'])){
        if($webhook_data['status'] == 'PAID'){
$amount = $invoice['amount'];

    // ✅ Update booking ke paid
    $this->booking->updateByPgRef($invoice_id, 'paid');
    $booking = $this->booking->getByInvoiceId($invoice_id);

    if ($booking) {
        // Buat chat otomatis
        $this->chat_model->insert([
            'client_id'  => $booking['client_id'],
            'lawyer_id'  => $booking['lawyer_id'],
            'booking_id' => $booking['id'],
        ]);

        // Hitung komisi
        $config = $this->referral_config->get_all(); 
        $gross  = $amount;
        $platform_fee = $gross * $config['platform_fee_pct'] / 100;
        $company_amt  = $platform_fee * $config['company_pct_of_fee'] / 100;
        $ref_pool     = $platform_fee - $company_amt;

        $l1_amt = $ref_pool * $config['l1_pct_of_pool'] / 100;
        $l2_amt = $ref_pool * $config['l2_pct_of_pool'] / 100;
        $l3_amt = $ref_pool * $config['l3_pct_of_pool'] / 100;
        $lawyer_amt = $gross - $platform_fee;

        $client   = $this->user->get_by_id($booking['client_id']);
        $l1_user  = $client['referrer_id'] ?? null;
        $l2_user  = $l1_user ? $this->user->get_referrer_id($l1_user) : null;
        $l3_user  = $l2_user ? $this->user->get_referrer_id($l2_user) : null;

        // ✅ Update saldo wallet
        $this->wallet->update_balance($booking['lawyer_id'], $lawyer_amt);
        $this->wallet->update_balance(1, $company_amt); // perusahaan

        if ($l1_user) $this->wallet->update_balance($l1_user, $l1_amt);
        else $this->wallet->update_balance(1, $l1_amt);

        if ($l2_user) $this->wallet->update_balance($l2_user, $l2_amt);
        else $this->wallet->update_balance(1, $l2_amt);

        if ($l3_user) $this->wallet->update_balance($l3_user, $l3_amt);
        else $this->wallet->update_balance(1, $l3_amt);

        // ✅ Simpan laporan komisi
        $this->commision->insert([
            'booking_id'     => $booking['id'],
            'gross_price'    => $gross,
            'platform_fee'   => $platform_fee,
            'company_amount' => $company_amt,
            'l1_user_id'     => $l1_user,
            'l1_amount'      => $l1_amt,
            'l2_user_id'     => $l2_user,
            'l2_amount'      => $l2_amt,
            'l3_user_id'     => $l3_user,
            'l3_amount'      => $l3_amt,
            'created_at'     => date('Y-m-d H:i:s')
        ]);
    }

        }

        // FIXED  VIRTUAL ACOUNT WEBHOOK
         if (isset($webhook_data['payment_id']) && isset($webhook_data['bank_code'])) {

                $external_id = $webhook_data['external_id'];
        $amount      = $webhook_data['amount'];
    $this->booking->updateByPgRef($external_id, 'paid');
        $booking = $this->booking->getByInvoiceId($external_id);

        if ($booking) {
            // Buat chat
            $this->chat_model->insert([
                'client_id'  => $booking['client_id'],
                'lawyer_id'  => $booking['lawyer_id'],
                'booking_id' => $booking['id'],
            ]);

            // Tambah saldo lawyer
            $config = $this->referral_config->get_all(); 
        $gross  = $amount;
        $platform_fee = $gross * $config['platform_fee_pct'] / 100;
        $company_amt  = $platform_fee * $config['company_pct_of_fee'] / 100;
        $ref_pool     = $platform_fee - $company_amt;

        $l1_amt = $ref_pool * $config['l1_pct_of_pool'] / 100;
        $l2_amt = $ref_pool * $config['l2_pct_of_pool'] / 100;
        $l3_amt = $ref_pool * $config['l3_pct_of_pool'] / 100;
        $lawyer_amt = $gross - $platform_fee;

        $client   = $this->user->get_by_id($booking['client_id']);
        $l1_user  = $client['referrer_id'] ?? null;
        $l2_user  = $l1_user ? $this->user->get_referrer_id($l1_user) : null;
        $l3_user  = $l2_user ? $this->user->get_referrer_id($l2_user) : null;

        // ✅ Update saldo wallet
        $this->wallet->update_balance($booking['lawyer_id'], $lawyer_amt);
        $this->wallet->update_balance(1, $company_amt); // perusahaan

        if ($l1_user) $this->wallet->update_balance($l1_user, $l1_amt);
        else $this->wallet->update_balance(1, $l1_amt);

        if ($l2_user) $this->wallet->update_balance($l2_user, $l2_amt);
        else $this->wallet->update_balance(1, $l2_amt);

        if ($l3_user) $this->wallet->update_balance($l3_user, $l3_amt);
        else $this->wallet->update_balance(1, $l3_amt);

        // ✅ Simpan laporan komisi
        $this->commision->insert([
            'booking_id'     => $booking['id'],
            'gross_price'    => $gross,
            'platform_fee'   => $platform_fee,
            'company_amount' => $company_amt,
            'l1_user_id'     => $l1_user,
            'l1_amount'      => $l1_amt,
            'l2_user_id'     => $l2_user,
            'l2_amount'      => $l2_amt,
            'l3_user_id'     => $l3_user,
            'l3_amount'      => $l3_amt,
            'created_at'     => date('Y-m-d H:i:s')
        ]);
        }
         }
    }

    
    http_response_code(200);
    echo json_encode(['status' => 'success', 'message' => 'Webhook processed via Xendit API']);
}

// Halaman success - Hanya untuk redirect dan checking
public function success() {
    $user_id = $this->session->userdata('user_id');
    // $invoice_id = $this->input->get('invoice_id');
      $booking = $this->booking->getLastByUser($user_id);



    
    
    // Tampilkan halaman waiting yang akan check status pembayaran
        if ($booking && $booking->status == 'paid') {
            
             
            $this->load->view('booking/success', ['booking' => $booking]);
        } else {
            // kalau webhook belum update
            $this->load->view('booking/waiting', ['booking' => $booking]);
        }
    // $this->load->view('booking/waiting', $data);
}

// API untuk check status pembayaran
public function check_payment_status($invoice_id) {
    header('Content-Type: application/json');
    
    try {
        // Get invoice details from Xendit
        Configuration::setXenditKey($this->config->item('xendit_api_key'));
        $apiInstance = new InvoiceApi();
        $invoice = $apiInstance->getInvoiceById($invoice_id);
        
        if ($invoice['status'] === 'PAID') {
            $external_id = $invoice['external_id'];
            $parts = explode('-', $external_id);
            
            if (count($parts) >= 4 && $parts[0] === 'booking') {
                $lawyer_id = $parts[2];
                $client_id = $parts[3];
                
                // Cari booking yang sudah dibuat oleh webhook
                $booking = $this->booking->get_by_client_lawyer($client_id, $lawyer_id);
                
                if ($booking) {
                    $chat = $this->chat_model->get_by_booking_id($booking['id']);
                    echo json_encode([
                        'status' => 'paid',
                        'redirect_url' => base_url('chat/booking/' . $chat['id'])
                    ]);
                    return;
                }
            }
        }
        
        echo json_encode(['status' => $invoice['status']]);
        
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

}