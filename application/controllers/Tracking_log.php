<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking_log extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // **WAJIB:** Muat Model Log Database
        $this->load->model('M_tracking'); 
        $this->load->database();
    }

    public function log_whatsapp_click()
    {
        if ($this->input->method() === 'post') {
            
            $ip_address = $this->input->ip_address();
            
            // Mengambil data menggunakan $this->input->post()
            $admin_id = $this->input->post('admin');
            
            if (empty($admin_id)) {
                $admin_id = 'Unknown/Empty Request';
            }

            // Panggil fungsi Model untuk menyimpan log
            $success = $this->M_tracking->log_whatsapp_click($ip_address, $admin_id); 
            
            $response = [
                'status' => $success ? 'success' : 'error',
                'message' => $success ? 'Log berhasil dicatat.' : 'Gagal mencatat log.',
                // Tambahkan debugging info
                'db_affected' => $success
            ];

        } else {
            $response = ['status' => 'error', 'message' => 'Method not allowed.'];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit(); 
    }
}