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
            'external_id' => 'invoice-' . time() . '-' . $lawyer_id,
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
            ],
            'fees' => [
                [
                    'type' => 'ADMIN',
                    'value' => 0 // Sesuaikan jika ada biaya admin
                ]
            ]
        ];

        $apiInstance = new InvoiceApi();
$create_invoice_request = new Xendit\Invoice\CreateInvoiceRequest($params); // \Xendit\Invoice\CreateInvoiceRequest
$for_user_id = ""; // string | Business ID of the sub-account merchant (XP feature)

try {
    $invoice = $apiInstance->createInvoice($create_invoice_request, $for_user_id);
        // print_r($result);
} catch (\Xendit\XenditSdkException $e) {
    echo 'Exception when calling InvoiceApi->createInvoice: ', $e->getMessage(), PHP_EOL;
    echo 'Full Error: ', json_encode($e->getFullError()), PHP_EOL;
}
        // Simpan data invoice ke database (opsional)
        $booking_data = [
            'client_id' => $this->session->userdata('user_id'),
            'lawyer_id' => $lawyer_id,
            'duration_minutes' => $data['duration'],
            'total_amount' => $total,
            'invoice_id' => $invoice['id'],
            'invoice_url' => $invoice['invoice_url'],
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Simpan ke database (sesuaikan dengan model Anda)
        // $this->booking_model->create($booking_data);

        echo json_encode([
            'status' => 'success',
            'message' => 'Invoice berhasil dibuat',
            'data' => $booking_data
        ]);
        
    } catch (Exception $e) {
        error_log('Xendit Error: ' . $e->getMessage());
        
        echo json_encode([
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat membuat invoice: ' . $e->getMessage()
        ]);
    }
}

}