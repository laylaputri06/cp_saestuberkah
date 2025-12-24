
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        // MUAT MODEL PRODUK
        $this->load->model('M_produk'); 
    }

   public function index($kategori = 'kemeja_dan_PDH') 
    {
        // 1. Daftar Judul Kategori (SESUAIKAN DENGAN ADMIN.PHP)
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
        // Hanya hitung jika pengunjung bukan admin yang sedang login (opsional)
        if($this->session->userdata('status') != 'login'){
            $this->db->set('view_count', 'view_count + 1', FALSE);
            $this->db->where('kategori', $kategori);
            $this->db->limit(1);
            $this->db->update('tb_produk');
        }

        $data['title']          = $judul[$kategori] . ' - Konveksi Saestu Berkah';
        $data['kategori_aktif'] = $kategori;
        $data['judul_halaman']  = $judul[$kategori];

        // 2. AMBIL DATA HANYA DARI DATABASE (Backend murni)
        // Jangan pakai looping manual 'for' lagi agar loading cepat
        $data['produk_list'] = $this->M_produk->get_produk_with_images($kategori);

        // Load View
        $this->load->view('v_produk', $data);
    }

    public function detail($id) {
    // Tambah jumlah kunjungan setiap kali halaman dibuka
        $this->db->set('view_count', 'view_count +1', FALSE);
        $this->db->where('id', $id);
        $this->db->update('tb_produk');

        // ... sisa kode untuk menampilkan view detail produk ...
    }

    public function hit_and_view($kategori)
    {
        // 1. Tambah +1 pada view_count untuk SEMUA produk dalam kategori tersebut
        // agar grafik kategori di dashboard meningkat
        $this->db->set('view_count', 'view_count + 1', FALSE);
        $this->db->where('kategori', $kategori);
        $this->db->limit(1);
        $this->db->update('tb_produk');

        // 2. Arahkan pengunjung ke halaman daftar produk kategori tersebut
        redirect('produk/index/' . $kategori);
    }
}