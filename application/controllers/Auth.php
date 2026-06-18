<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session 
 * @property CI_Form_validation 
 * @property CI_Input 
 * @property CI_Loader 
 * @property CI_DB_query_builder  
 * @property M_auth 
 */
class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database(); 
        $this->load->model('M_auth'); 
        
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function login()
    {
        if($this->session->userdata('status') == 'login'){
            redirect('admin/dashboard');
        }

        $ip_address = $this->input->ip_address();
        
        if ($this->M_auth->check_limit($ip_address)) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning" role="alert">Terlalu banyak upaya login gagal. Silakan coba lagi setelah beberapa saat.</div>');
            $data['title'] = 'Login Admin - Konveksi Saestu Berkah';
            $this->load->view('admin/v_login', $data);
            return; 
        }

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Login Admin - Konveksi Saestu Berkah';
            $this->load->view('admin/v_login', $data);
        } else {

            $input_user = $this->input->post('username', TRUE);
            $input_pass = $this->input->post('password', TRUE);

            $admin = $this->M_auth->get_admin_by_username($input_user);

            if($admin && password_verify($input_pass, $admin->password)){
                $data_session = array(
                    'id_admin' => $admin->id,
                    'username' => $admin->username, 
                    'status' => 'login'
                );
                $this->session->set_userdata($data_session);
                
                redirect('admin/dashboard');

            } else {
                $this->M_auth->log_attempt($input_user, $ip_address); 
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