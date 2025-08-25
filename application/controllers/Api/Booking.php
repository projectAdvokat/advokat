<?php

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
        $data = $this->input->post();
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
}