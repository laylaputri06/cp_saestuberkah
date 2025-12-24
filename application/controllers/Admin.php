<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Session 
 * @property CI_Loader 
 * @property CI_DB_query_builder 
 * @property M_dashboard 
 * @property M_auth 
 */

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->model('M_dashboard');
        $this->load->model('M_produk');

        // Cek Login
        if($this->session->userdata('status') != 'login'){
            redirect('auth/login');
        }
    }

    public function dashboard()
    {
        $data['title'] = 'Dashboard - Konveksi Saestu Berkah';
        $data['nama_admin'] = $this->session->userdata('nama');
        $this->load->helper('date');
        date_default_timezone_set('Asia/Jakarta');
        $data['tanggal'] = date('l, d F Y');

        $data['total_produk']   = $this->M_dashboard->get_total_produk();
        $data['total_wa']       = $this->M_dashboard->get_total_wa_clicks();
        $data['total_visitors'] = $this->M_dashboard->get_total_unique_visitors();

        $data['top_products']   = $this->M_dashboard->get_top_visited_products(7);

        $data['latest_activities'] = $this->M_dashboard->get_latest_activities(3);
        $this->load->view('admin/v_dashboard', $data);
    }

    // application/controllers/Admin.php

    public function get_kpi_json()
    {
        $this->load->model('M_dashboard'); 

        $data_kpi = array(
            'total_produk'   => $this->M_dashboard->get_total_produk(),
            'total_wa'       => $this->M_dashboard->get_total_wa_clicks(),
            'total_visitors' => $this->M_dashboard->get_total_unique_visitors()
        );

        // Header wajib untuk memastikan browser tahu ini adalah JSON
        header('Content-Type: application/json');
        
        // Kirim data dalam format JSON
        echo json_encode($data_kpi);
        
        // Penting: Hentikan eksekusi script
        exit(); 
    }

    public function riwayat()
    {
        $data['title'] = 'Riwayat Aktivitas - Konveksi Saestu Berkah';
        $data['nama_admin'] = $this->session->userdata('nama');
        $this->load->helper('date');
        date_default_timezone_set('Asia/Jakarta');
        $data['tanggal'] = date('l, d F Y');
        $data['all_activities'] = $this->db->order_by('id', 'DESC')->get('tb_riwayat_aktivitas')->result_array();
        
        // AMBIL DATA DARI MODEL (Menggantikan data dummy)
        $data['logs'] = $this->M_dashboard->get_all_activities();

        $this->load->view('admin/v_riwayat', $data);
    }

    public function export_riwayat_csv()
    {
        // Pastikan helper download dimuat
        $this->load->helper('download'); 

        $riwayat = $this->M_dashboard->get_all_activities();

        if (empty($riwayat)) {
            $this->session->set_flashdata('error', 'Tidak ada riwayat aktivitas untuk diunduh.');
            redirect('admin/riwayat');
        }

        // Siapkan Header dan Data CSV
        $csv_output = '';
        
        // Header (Kolom)
        $column_names = array_keys($riwayat[0]);
        $csv_output .= implode(';', $column_names) . "\n";
        
        // Isi Data
        foreach ($riwayat as $row) {
            $csv_output .= implode(';', array_values($row)) . "\n";
        }
        
        // Unduh File
        $filename = 'riwayat_aktivitas_' . date('Ymd_His') . '.csv';
        force_download($filename, $csv_output);
    }


    // --- FUNGSI PRODUK (LOGIKA KATEGORI + 45 DATA) ---
    public function produk($kategori = null) // Ubah default menjadi null
{
    $this->load->model('M_dashboard');
    $data['title'] = "Kelola Produk";
    $data['tanggal'] = date('l, d F Y');
    $data['nama_admin'] = $this->session->userdata('nama_admin');

    if ($kategori === null) {
        // --- TAMPILAN RINGKASAN (DASHBOARD PRODUK) ---
        $data['is_dashboard'] = true;
        $data['kategori_aktif'] = 'semua';
        $data['judul_kategori'] = 'Ringkasan Produk';

        // Ambil data terbatas (misal: 5 item) untuk setiap kategori
        $data['preview_kemeja'] = $this->M_produk->get_produk_limit('kemeja_dan_PDH', 5);
        $data['preview_polo']   = $this->M_produk->get_produk_limit('kaos_polo', 5);
        $data['preview_polos']  = $this->M_produk->get_produk_limit('kaos_polos', 5);
        $data['preview_rompi']  = $this->M_produk->get_produk_limit('rompi', 5);
        $data['preview_galeri'] = $this->M_produk->get_produk_limit('galeri', 4); // Galeri biasanya 4 (2x2)
        
        $data['products'] = []; // Kosongkan karena menggunakan preview masing-masing
    } else {
        // --- TAMPILAN DETAIL KATEGORI (KODE LAMA ANDA) ---
        $data['is_dashboard'] = false;
        $data['kategori_aktif'] = $kategori;
        $data['products'] = $this->M_produk->get_produk_with_images($kategori);

        $judul = [
            'kemeja_dan_PDH' => 'Kemeja dan PDH',
            'kaos_polo'      => 'Kaos Polo',
            'kaos_polos'     => 'Kaos Polos',
            'rompi'          => 'Rompi',    
            'galeri'         => 'Galeri Pelanggan'
        ];
        $data['judul_kategori'] = $judul[$kategori] ?? 'Produk';
    }

    $this->load->view('admin/v_produk', $data);
}

    public function save_produk() {
        $this->load->model('M_produk');

        $nama_admin = $this->session->userdata('nama_admin');
        if (empty($nama_admin)) {
            $nama_admin = 'Admin'; 
        }

        $kategori   = $this->input->post('kategori');
        $nomor_file = $this->input->post('nomor_file'); // Memperbaiki Error: Undefined variable $nomor_urut

        $data_riwayat = [
            'deskripsi' => 'Berhasil menambahkan produk baru kategori: ' . $this->input->post('kategori'),
            'waktu'     => date('Y-m-d H:i:s'),
            'oleh'      => $nama_admin // Ini yang sebelumnya NULL sehingga error
        ];
        $this->db->insert('tb_riwayat_aktivitas', $data_riwayat);

        // 3. Simpan data utama ke tb_produk
        $data_induk = [
            'kategori'   => $kategori,
            'status'     => 'aktif',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Simpan ke variabel $produk_id agar bisa dipakai di bawah
        $produk_id = $this->M_produk->insert_produk_utama($data_induk);

        // 4. Konfigurasi Folder Upload
        $path = './assets/images/produk/' . $kategori . '/';
        if (!is_dir($path)) { mkdir($path, 0777, true); }

        $config['upload_path']   = $path;
        $config['allowed_types'] = 'jpg|png';
        $config['file_name']     = $nomor_file; 
        $config['overwrite']     = TRUE;

        $this->load->library('upload');
       $this->upload->initialize($config);

        // 5. Proses Upload
        if ($this->upload->do_upload('foto_produk')) {
            $upload_data = $this->upload->data();
            
            // Simpan detail ke tb_produk_image
            $data_foto = [
                'produk_id'   => $produk_id,
                'file_name'   => $upload_data['file_name'],
                'image_order' => $nomor_file
            ];
            
            // Memanggil fungsi dari model yang benar
            $this->M_produk->insert_single_image($data_foto);
            // $this->M_dashboard->add_aktivitas("Berhasil menambahkan produk baru kategori: " . $kategori);
            $this->session->set_flashdata('success', 'Produk Berhasil Disimpan!');
            redirect('admin/produk/' . $kategori);  

        } else {
        // JIKA UPLOAD GAGAL: Hapus data induk agar database tidak kotor
        $this->db->delete('tb_produk', ['id' => $produk_id]);
        $error_msg = $this->upload->display_errors();
        die("LOG ERROR: " . $error_msg . " | Jalur: " . realpath($path));
    }
    }

    // hapus produk
    public function hapus_produk($id, $kategori)
    {
        // 1. Ambil data produk sebelum dihapus untuk keperluan riwayat
        $produk = $this->db->get_where('tb_produk', ['id' => $id])->row_array();
        $gambar = $this->db->get_where('tb_produk_image', ['produk_id' => $id])->row_array();

        if ($produk) {
            //Hapus file fisik gambar di folder agar penyimpanan tidak penuh
            if ($gambar) {
                $path_foto = './assets/images/produk/' . $kategori . '/' . $gambar['file_name'];
                if (file_exists($path_foto)) {
                    unlink($path_foto); 
                }
            }

            // Hapus data di database (Kedua tabel)
            $this->db->delete('tb_produk_image', ['produk_id' => $id]); 
            $this->db->delete('tb_produk', ['id' => $id]);

            // 3. Catat Aktivitas (agar muncul di dashboard dan)
            $deskripsi = "Berhasil menghapus produk kategori: " . strtoupper($kategori);
            $this->M_dashboard->add_aktivitas($deskripsi);

            $this->session->set_flashdata('pesan', 'Produk berhasil dihapus!');
        }

        redirect('admin/produk/' . $kategori);
    }

    public function update_produk()
    {
        $id = $this->input->post('id');
        $kategori = $this->input->post('kategori');
        $nama_admin = $this->session->userdata('nama_admin') ?? 'Admin';

        // 1. Ambil data lama untuk keperluan hapus file fisik jika foto diganti
        $old_image = $this->db->get_where('tb_produk_image', ['produk_id' => $id])->row_array();

        // 2. Update Kategori di tabel induk
        $this->db->where('id', $id);
        $this->db->update('tb_produk', ['kategori' => $kategori]);

        // 3. Cek apakah admin mengupload foto baru
        if (!empty($_FILES['foto_produk']['name'])) {
            $path = './assets/images/produk/' . $kategori . '/';
            if (!is_dir($path)) { mkdir($path, 0777, true); }

            $config['upload_path']   = $path;
            $config['allowed_types'] = 'jpg|png';
            $config['overwrite']     = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('foto_produk')) {
                // Hapus foto lama di folder agar tidak menumpuk
                if ($old_image) {
                    $old_path = './assets/images/produk/' . $kategori . '/' . $old_image['file_name'];
                    if (file_exists($old_path)) { unlink($old_path); }
                }

                $upload_data = $this->upload->data();
                $this->db->where('produk_id', $id);
                $this->db->update('tb_produk_image', ['file_name' => $upload_data['file_name']]);
            }
        }

        // 4. Catat SATU baris riwayat saja agar tidak bug
        $this->M_dashboard->add_aktivitas("Berhasil mengedit data produk ID: " . $nomor_urut . " (Kategori: " . $kategori . ")");
        $this->session->set_flashdata('success', 'Data produk berhasil diperbarui!');
        redirect('admin/produk/' . $kategori);
    }

    // --- FUNGSI KELOLA HALAMAN ---
    public function halaman()
    {
        $data['title'] = 'Kelola Halaman - Konveksi Saestu Berkah';
        $data['nama_admin'] = $this->session->userdata('nama');
        
        date_default_timezone_set('Asia/Jakarta');
        $data['tanggal'] = date('l, d F Y');

        // AMBIL DATA DARI DATABASE (Bukan Dummy)
        $data['welcome']    = $this->M_dashboard->get_halaman_by_slug('beranda');
        $data['about']      = $this->M_dashboard->get_halaman_by_slug('tentang_kami');
        $data['visi_misi']  = $this->M_dashboard->get_halaman_by_slug('visi_misi');

        $this->load->view('admin/v_halaman', $data);
    }

   public function update_konten_halaman() 
   {
        $slug = $this->input->post('slug');
        
        // 1. Ambil data dasar
        $data_update = [
            'judul_kecil' => $this->input->post('judul_kecil'),
            'judul_utama' => $this->input->post('judul_utama')
        ];

        // 2. Logika khusus untuk Visi & Misi
        if ($slug == 'visi_misi') {
            $misi_input = $this->input->post('misi');
            $data_update['deskripsi'] = implode("\n", array_filter($misi_input)); 
        } else {
            $data_update['deskripsi'] = $this->input->post('deskripsi');
        }

        // 3. Proses Ganti Foto
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path']   = './assets/images/';
            $config['allowed_types'] = 'jpg|png|jpeg'; // Tambahkan jpeg agar lebih fleksibel
            $config['file_name']     = $slug . '_' . time();
            
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // EKSEKUSI UPLOAD (Penting!)
            if ($this->upload->do_upload('foto')) {
                $upload_data = $this->upload->data();
                $file_baru = $upload_data['file_name'];

                $old_data = $this->db->get_where('tb_halaman', ['slug' => $slug])->row();
                
                if ($old_data && $old_data->foto) {
                    $path_lama = './assets/images/' . $old_data->foto;
                    if (file_exists($path_lama)) {
                        unlink($path_lama); // Hapus file fisik lama
                    }
                }

                // SIMPAN NAMA FILE BARU KE DATABASE
                $data_update['foto'] = $file_baru;
            }
        }

        // 4. Update Database
        $this->db->where('slug', $slug);
        $this->db->update('tb_halaman', $data_update);

        $nama_hal = ucwords(str_replace('_', ' ', $slug));
        $this->session->set_flashdata('success', "Berhasil mengedit Halaman $nama_hal!");
        $this->M_dashboard->add_aktivitas("Berhasil mengedit konten pada Halaman $nama_hal");

        redirect('admin/halaman');
    }

    // ==========================================
    //  FUNGSI BARU: PENGATURAN LAYANAN & KONTAK
    // ==========================================
    
   public function layanan()
    {
        $data['title'] = 'Pengaturan Layanan & Kontak';
        $data['nama_admin'] = $this->session->userdata('nama');
        
        date_default_timezone_set('Asia/Jakarta');
        $data['tanggal'] = date('l, d F Y');

        // MENGAMBIL DATA DARI DATABASE (ID 1 sesuai baris yang kita buat di SQL)
        $data['konfig'] = $this->db->get_where('tb_konfigurasi', ['id' => 1])->row();
        
        $this->load->view('admin/v_layanan', $data);
    }

    public function update_layanan() 
    {
        // Ambil nomor WA dan tambahkan prefix '62' di depannya
        $wa1 = $this->input->post('no_wa_1');
        $wa2 = $this->input->post('no_wa_2');
        
        // 1. Ambil semua input dari form
        $data_update = [
            'no_wa_1'         => '62' . ltrim($wa1, '0'), // Menghapus angka 0 di depan jika ada, lalu tambah 62
            'no_wa_2'         => '62' . ltrim($wa2, '0'),
            'email'           => $this->input->post('email'),
            'jam_operasional' => $this->input->post('jam_buka'),
            'alamat'          => $this->input->post('alamat'),
            'instagram'       => $this->input->post('instagram'),
            'tiktok'          => $this->input->post('tiktok'),
            'facebook'        => $this->input->post('facebook'),
            'youtube'         => $this->input->post('youtube'),
            'mbizmarket'      => $this->input->post('mbizmarket')
        ];

        // 2. Eksekusi update ke baris ID 1
        $this->db->where('id', 1);
        $this->db->update('tb_konfigurasi', $data_update);

        // 3. Catat aktivitas dan beri notifikasi
        $this->M_dashboard->add_aktivitas("Berhasil memperbarui data layanan dan kontak");
        $this->session->set_flashdata('success', 'Pengaturan layanan berhasil diperbarui!');
        
        redirect('admin/layanan');
    }

}