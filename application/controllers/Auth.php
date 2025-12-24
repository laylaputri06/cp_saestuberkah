<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Loader $load
 * @property CI_DB_query_builder $db  
 * @property M_auth $M_auth
 */
class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // LOAD DATABASE dan MODEL (Wajib untuk otentikasi aman)
        $this->load->database(); 
        $this->load->model('M_auth'); 
        
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function login()
    {
        // 1. Cek Session: Kalau sudah login, langsung lempar ke dashboard
        if($this->session->userdata('status') == 'login'){
            redirect('admin/dashboard');
        }

        // RATE LIMITING CHECK (Pencegahan Brute Force)
        $ip_address = $this->input->ip_address();
        
        // Cek apakah IP ini sudah melampaui batas (misal: 5x dalam 5 menit)
        if ($this->M_auth->check_limit($ip_address)) {
            // Jika batas tercapai, tampilkan peringatan dan HENTIKAN proses.
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning" role="alert">Terlalu banyak upaya login gagal. Silakan coba lagi setelah beberapa saat.</div>');
            $data['title'] = 'Login Admin - Konveksi Saestu Berkah';
            $this->load->view('admin/v_login', $data);
            return; // Hentikan eksekusi di sini
        }

        // 2. Aturan Validasi Form
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            // Tampilkan Halaman Login lagi kalau form kosong
            $data['title'] = 'Login Admin - Konveksi Saestu Berkah';
            $this->load->view('admin/v_login', $data);
        } else {
            // 3. PROSES otentikasi aman dari database.
            
            $input_user = $this->input->post('username', TRUE);
            $input_pass = $this->input->post('password', TRUE);

            // Cari admin berdasarkan username (Aman dari SQL Injection)
            $admin = $this->M_auth->get_admin_by_username($input_user);

            // Cek apakah USER ditemukan dan passw cocok
            if($admin && password_verify($input_pass, $admin->password)){
                
                // Kalau BENAR, buat session
                $data_session = array(
                    'id_admin' => $admin->id,
                    'username' => $admin->username, 
                    'status' => 'login'
                );
                $this->session->set_userdata($data_session);
                
                // Masuk ke Dashboard
                redirect('admin/dashboard');

            } else {
                // Kalau LOGIN gagal, catat upaya gagal ke database
                $this->M_auth->log_attempt($input_user, $ip_address); 
                //beri pesan error
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Username atau Password salah!</div>');
                redirect('auth/login');
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}