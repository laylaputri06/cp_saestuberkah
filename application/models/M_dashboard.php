<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model {

    // --- Statistik Utama (KPIs) ---

    // 1. Total Produk Aktif
    public function get_total_produk()
    {
        // Asumsi: Kolom 'status' = 'aktif' atau 1
        $this->db->where('status', 'aktif');
        return $this->db->count_all_results('tb_produk');
    }

    public function get_produk_with_images($kategori = null) {
        $this->db->select('tb_produk.*, tb_produk_image.file_name');
        $this->db->from('tb_produk');
        // Menghubungkan ID di tb_produk dengan produk_id di tb_produk_image
        $this->db->join('tb_produk_image', 'tb_produk.id = tb_produk_image.produk_id', 'left');
        
        if ($kategori) {
            $this->db->where('tb_produk.kategori', $kategori);
        }
        
        return $this->db->get()->result_array();
    }

    // 2. Total Konsultasi WhatsApp
    public function get_total_wa_clicks()
    {
        $this->db->select('COUNT(id) as total_wa');
        $this->db->from('tb_logs_whatsapp'); 
        $query = $this->db->get();

        // Jika ada hasil, kembalikan angkanya. Jika tidak, kembalikan 0
        if ($query->num_rows() > 0) {
            return $query->row()->total_wa;
        }
        return 0;
    }

    public function get_total_unique_visitors()
    {
        // Menghitung semua baris di tabel log visitor
        return $this->db->count_all('tb_logs_visitor'); 
    }

    public function get_top_visited_products()
    {
        // Menghitung total view_count untuk setiap kategori
        $this->db->select('kategori, MAX(view_count) as total_views');
        $this->db->where('kategori !=', 'galeri');
        $this->db->group_by('kategori');
        $this->db->order_by('total_views', 'DESC');
        return $this->db->get('tb_produk')->result_array();
    }

    // Halman Dashboard Admin
    public function get_halaman_by_slug($slug) {
        return $this->db->get_where('tb_halaman', ['slug' => $slug])->row_array();
    }

    // --- Aktivitas Website ---
    public function get_latest_activities($limit = 3)
    {
        // Ambil 3 aktivitas terbaru
        $this->db->select('id, deskripsi, waktu, oleh');
        $this->db->order_by('id', 'DESC'); 
        $this->db->limit($limit);
        
        return $this->db->get('tb_riwayat_aktivitas')->result_array();
    }

    // simpan riwayat aktivitas
    public function add_aktivitas($deskripsi)
    {
        $data = [
            'deskripsi' => $deskripsi,
            'waktu'     => date('Y-m-d H:i:s'), 
            'oleh'      =>($admin) ? $admin : 'Admin'
        ];
        return $this->db->insert('tb_riwayat_aktivitas', $data);
    }

    // --- Semua Riwayat Aktivitas (Untuk CSV) ---
    public function get_all_activities()
    {
        // Ambil semua data dari tabel riwayat
        $this->db->order_by('waktu', 'DESC');
        return $this->db->get('tb_riwayat_aktivitas')->result_array();
    }

}