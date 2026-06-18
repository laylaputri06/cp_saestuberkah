
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_produk'); 
    }

   public function index($kategori = 'kemeja_dan_PDH') 
    {
        $judul = [
            'kemeja_dan_PDH' => 'Seragam Kemeja & PDH',
            'kaos_polo'      => 'Seragam Polo',
            'kaos_polos'     => 'Kaos Polos',
            'rompi'          => 'Seragam Rompi',
            'galeri'         => 'Galeri Pelanggan'
        ];
        
        // Validasi Kategori agar tidak error
        if (!array_key_exists($kategori, $judul)) {
            $kategori = 'kemeja_dan_PDH';
        }

        // --- PENAMBAHAN VIEW COUNT ---
        if($this->session->userdata('status') != 'login'){
            $this->db->set('view_count', 'view_count + 1', FALSE);
            $this->db->where('kategori', $kategori);
            $this->db->limit(1);
            $this->db->update('tb_produk');
        }

        $data['title']          = $judul[$kategori] . ' - Konveksi Saestu Berkah';
        $data['kategori_aktif'] = $kategori;
        $data['judul_halaman']  = $judul[$kategori];

        $data['produk_list'] = $this->M_produk->get_produk_with_images($kategori);

        $this->load->view('v_produk', $data);
    }

    public function detail($id) {
        $this->db->set('view_count', 'view_count +1', FALSE);
        $this->db->where('id', $id);
        $this->db->update('tb_produk');
    }

    public function hit_and_view($kategori)
    {
        $this->db->set('view_count', 'view_count + 1', FALSE);
        $this->db->where('kategori', $kategori);
        $this->db->limit(1);
        $this->db->update('tb_produk');

        redirect('produk/index/' . $kategori);
    }
}