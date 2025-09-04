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

    public function get_by_client($id) {
        // $client_id = $this->session->userdata('user_id'); // user login
        //  if (!$client_id) {
        //     api_response(false, null, 'Unauthorized');
        //     return;
        // }
        $bookings = $this->booking->get_by_client($id);
        api_response(true, $bookings);
    }

    // pay with midtrans
    public function pay($lawyer_id) {
    header('Content-Type: application/json');

    // baca body JSON dari fetch()
    $data = json_decode($this->input->raw_input_stream, true);

    if (!$lawyer_id || empty($data['duration'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Lawyer ID dan durasi harus diisi'
        ]);
        return;
    }

    $lawyer = api_get('/api/lawyer/show/'.$lawyer_id)['data'];
    $quantity = ceil($data['duration'] / 30); 
    $price = intval($lawyer['price_30m']);
    $total = $price * $quantity;

    // Set Xendit API Key
    Configuration::setXenditKey($this->config->item('xendit_api_key'));

    try {
        $params = [
            'external_id' => 'booking-' . time() . '-' . $lawyer_id . '-' . $this->session->userdata('user_id'),
            'payer_email' => $this->session->userdata('user_email') ?? 'customer@example.com',
            'description' => 'Konsultasi Hukum dengan ' . $lawyer['name'] . ' (' . $data['duration'] . ' menit)',
            'amount' => $total,
            'success_redirect_url' => base_url('booking/success'),
            'failure_redirect_url' => base_url('booking/failure'),
            'currency' => 'IDR',
            'items' => [
                [
                    'name' => 'Konsultasi Hukum ' . $data['duration'] . ' menit',
                    'quantity' => $quantity,
                    'price' => $price,
                    'category' => 'Legal Services'
                ]
            ]
        ];

        $apiInstance = new InvoiceApi();
        $create_invoice_request = new Xendit\Invoice\CreateInvoiceRequest($params);
        $invoice = $apiInstance->createInvoice($create_invoice_request);

        $this->booking->insert([
    'client_id' => $this->session->userdata('user_id'),
    'lawyer_id' => $lawyer_id,
    'duration_minutes' => $data['duration'],
    'price_snapshot' => $total,
    'pg_ref' => $invoice['id'], // simpan di pg_ref
    'status' => 'pending',
    'created_at' => date('Y-m-d H:i:s')
]); 
        

        echo json_encode([
            'status' => 'success',
            'message' => 'Invoice berhasil dibuat',
            'data' => [
                'invoice_url' => $invoice['invoice_url']
            ]
        ]);
        
    } catch (Exception $e) {
        error_log('Xendit Error: ' . $e->getMessage());
        echo json_encode([
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat membuat invoice: ' . $e->getMessage()
        ]);
    }
}

// Webhook handler untuk Xendit (PENTING!)
public function xendit_webhook() {
    $raw_input = file_get_contents("php://input");
    
    $webhook_data = json_decode($raw_input, true);
    
    // Verifikasi signature
    $callback_token = $this->config->item('xendit_callback_token');
    $xendit_signature = $_SERVER['HTTP_X_CALLBACK_TOKEN'] ?? '';
    // var_dump($webhook_data);
    
    if ($callback_token && $xendit_signature !== $callback_token) {
        http_response_code(403);
        echo 'Invalid callback token';
        return;
    }
    
    if ($webhook_data['status'] === 'PAID') {
        
        $invoice_id = $webhook_data['id'];
        $external_id = $webhook_data['external_id'];
        
        // Parse external_id: booking-{timestamp}-{lawyer_id}-{client_id}
        $parts = explode('-', $external_id);
        
        if (count($parts) >= 4 && $parts[0] === 'booking') {
            $lawyer_id = $parts[2];
            $client_id = $parts[3];
            $amount = $webhook_data['amount'];
            
            // 1. BUAT BOOKING (HANYA SETELAH PEMBAYARAN BERHASIL)
              if ($webhook_data['status'] === 'PAID') {

        $this->booking->updateByPgRef($invoice_id, 'paid');
      $booking =  $this->booking->getByInvoiceId($invoice_id);

         $chat_data = [
             'client_id' => $booking->client_id,   // atau ganti kalau nama kolomnya client_id
        'lawyer_id' => $booking->lawyer_id,
        'booking_id' => $booking->id,
            ];
          
        
    }

            // 2. BUAT CHAT SESSION
            $chat_data = [
                'client_id' => $client_id,
                'lawyer_id' => $lawyer_id,
                'booking_id' => $booking_id,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            // $chat_id = $this->chat_model->insert($chat_data);
            
            http_response_code(200);
            echo 'Webhook processed successfully';
        }
    }
}

// Halaman success - Hanya untuk redirect dan checking
public function success() {
    $user_id = $this->session->userdata('user_id');
    // $invoice_id = $this->input->get('invoice_id');
      $booking = $this->booking->getLastByUser($user_id);



    
    
    // Tampilkan halaman waiting yang akan check status pembayaran
        if ($booking && $booking->status == 'paid') {
            
              $chat_data = [
             'client_id' => $user_id,   // atau ganti kalau nama kolomnya client_id
        'lawyer_id' => $booking->lawyer_id,
        'booking_id' => $booking->id,
            ];
          
                $this->chat_model->insert($chat_data);
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