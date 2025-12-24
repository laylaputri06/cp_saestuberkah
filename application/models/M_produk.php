<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_produk extends CI_Model {

    // 1. Menyimpan data utama produk ke tb_produk
    public function insert_produk_utama($data) {
        $this->db->insert('tb_produk', $data);
        return $this->db->insert_id(); 
    }

    // 2. Menyimpan detail gambar ke tb_produk_image
    public function insert_single_image($data) {
        return $this->db->insert('tb_produk_image', $data);
    }
    
    public function get_produk_with_images($kategori = null) {
        $this->db->select('tb_produk.*, tb_produk_image.file_name');
        $this->db->from('tb_produk');
        // Menghubungkan ID di tb_produk dengan produk_id di tb_produk_image
        $this->db->join('tb_produk_image', 'tb_produk.id = tb_produk_image.produk_id', 'left');
        
        if ($kategori) {
            $this->db->where('tb_produk.kategori', $kategori);
        }
        
        $this->db->group_by('tb_produk.id');
        return $this->db->get()->result_array();
    }
    // Update produk utama dan gambar
    public function update_produk_utama($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tb_produk', $data);
    }

    public function update_produk_image($produk_id, $data) {
        $this->db->where('produk_id', $produk_id);
        return $this->db->update('tb_produk_image', $data);
    }

    // 3. Mengambil data untuk list di Dashboard
    public function get_produk_by_kategori($kategori) {
        $this->db->select('tb_produk.*, tb_produk_image.file_name, tb_produk_image.image_order');
        $this->db->from('tb_produk');
        $this->db->join('tb_produk_image', 'tb_produk.id = tb_produk_image.produk_id', 'left');
        $this->db->where('tb_produk.kategori', $kategori);
        $this->db->order_by('tb_produk_image.image_order', 'ASC');
        
        return $this->db->get()->result_array();
    }

    public function get_produk_limit($kategori, $limit) {
    $this->db->select('tb_produk.*, tb_produk_image.file_name');
    $this->db->from('tb_produk');
    $this->db->join('tb_produk_image', 'tb_produk.id = tb_produk_image.produk_id');
    $this->db->where('tb_produk.kategori', $kategori);
    $this->db->limit($limit);
    $this->db->order_by('tb_produk.id', 'DESC'); // Produk terbaru di depan
    return $this->db->get()->result_array();
}

    // 4. Menghapus produk dan file fisiknya
    public function delete_produk($id) {
        $this->db->delete('tb_produk_image', ['produk_id' => $id]);
        return $this->db->delete('tb_produk', ['id' => $id]);
    }
}