<?php
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class Booking extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Booking_Model', 'booking');
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

    // pay with midtrans
    public function pay($lawyer_id){
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

// harga per 30 menit
$price = intval($lawyer['price_30m']);

// total harus sama dengan price * quantity
$total = $price * $quantity;
        /*Install Midtrans PHP Library (https://github.com/Midtrans/midtrans-php)
composer require midtrans/midtrans-php
                              
Alternatively, if you are not using **Composer**, you can download midtrans-php library 
(https://github.com/Midtrans/midtrans-php/archive/master.zip), and then require 
the file manually.   

require_once dirname(__FILE__) . '/pathofproject/Midtrans.php'; */

//SAMPLE REQUEST START HERE

// Set your Merchant Server Key
Config::$serverKey = $this->config->item('midtrans_server_key');
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
Config::$isProduction = false;
// Set sanitization on (default)
Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
Config::$is3ds = true;


$params = array(
    'transaction_details' => array(
        'order_id' => rand(),
        'gross_amount' => $total, // harus sama dengan sum(item_details)
    ),
    'item_details' => array(
        array(
            'id' => $lawyer_id,
            'name' => $lawyer['name'] . " - Konsultasi",
            'price' => $price,  // harga per 30 menit
            'quantity' => $quantity // jumlah blok 30 menit
        )
    ),
    'customer_details' => array(
        'first_name' => 'Budi',
        'last_name' => 'Pratama',
        'email' => 'budi.pra@example.com',
        'phone' => '08111222333',
    ),
);

$snapToken = \Midtrans\Snap::getSnapToken($params);
api_response(true, $snapToken);
    }
    
}