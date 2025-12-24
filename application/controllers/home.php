<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_tracking'); 
        $this->load->model('M_dashboard');
        $this->load->database(); 
    }

    public function index()
    {
        // 3. MEMANGGIL FUNGSI TRACKING SEBELUM MEMUAT VIEW
        $this->_track_unique_visitor(); 
        
        $data['title'] = 'Konveksi Saestu Berkah - Home'; 

        // Ambil data terbaru dari database hasil input admin
        $data['welcome']    = $this->M_dashboard->get_halaman_by_slug('beranda');
        $data['about']      = $this->M_dashboard->get_halaman_by_slug('tentang_kami');
        $data['visi_misi']  = $this->M_dashboard->get_halaman_by_slug('visi_misi');

        $data['konfig']     = $this->db->get_where('tb_konfigurasi', ['id' => 1])->row();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar'); 
        $this->load->view('v_home');
        $this->load->view('layout/footer');
        
    }

    private function _track_unique_visitor()
    {
        $ip_address = $this->input->ip_address();

        // Cek apakah IP ini sudah tercatat dalam 24 jam terakhir di M_tracking
        if ($this->M_tracking->is_unique_visitor($ip_address)) {
            $this->M_tracking->log_unique_visitor($ip_address);
        }
    }
}