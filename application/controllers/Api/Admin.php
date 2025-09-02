<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// noted: api response ini buatan gw sendiri, jdi klo mau edit response nya di application/helpers/api_helper.php

class Admin extends CI_Controller {
   public function __construct() {
        parent::__construct();
          $this->load->model('Admin_Action_Model', 'admin_action');
        
    }

    public function ban_user($id) {
        $result = $this->admin_action->ban_user($id); 

        
        
        if ($result > 0) {
            api_response(true, null, "User $id banned");
        } else {
            api_response(false, null, "Failed to ban user $id");
        }

                
        

    }
    public function unban_user($id) {
        $result = $this->admin_action->unban_user($id); 

        
        
        if ($result > 0) {
            api_response(true, null, "User $id unbanned");
        } else {
            api_response(false, null, "Failed to unban user $id");
        }

                
        

    }

    public function verify_lawyer($id) {
        $result = $this->admin_action->verify_lawyer($id);

        if ($result > 0) {
            $this->admin_action->log_action(1, 'lawyer', $id, 'verify', 'lawyer verified');
            api_response(true, null, "Lawyer $id verified");
        } else {
            api_response(false, null, "Lawyer not found or already verified");
        }
    }

    public function ban_article($id) {
        $result = $this->admin_action->ban_article($id, 'banned'); 

        
        // $this->admin_action->create('user', $id, 'ban', 'Violation of terms');
        if ($result > 0) {
            api_response(true, null, "Article $id banned");
        } else {
            api_response(false, null, "Failed to ban article $id");
        }


        api_response(true, null, "article $id banned");
    }

     public function reports_finance() {
        $from = $this->input->get('from') ?: date('Y-m-01');
        $to   = $this->input->get('to')   ?: date('Y-m-t');

        $report = $this->admin_action->get_finance_report($from, $to);

        api_response(true, $report, "Finance report from $from to $to");
    }
     
}
