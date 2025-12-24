<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tracking extends CI_Model {

        public function log_whatsapp_click($ip_address, $admin_selected = null)
        {
            $data = array(
                'ip_address'      => $ip_address,
                'timestamp'       => time(), 
                //'admin_selected'  => $admin_selected 
            );
            
            // Simpan data ke tabel logs
            $this->db->insert('tb_logs_whatsapp', $data); 
            
            // Tambahkan pengecekan error database di sini (hanya untuk debugging)
            $db_error = $this->db->error();
            if (!empty($db_error['message'])) {
                // Jika ada error database, tampilkan di console log
                log_message('error', 'DB INSERT ERROR in M_tracking: ' . $db_error['message']);
                return 0; // Kembalikan 0 jika gagal
            }
            
            return $this->db->affected_rows(); // Kembalikan 1 jika berhasil
        }
    

        public function is_unique_visitor($ip_address)
        {
            // Tentukan batas waktu (misalnya, 24 jam lalu)
            $twenty_four_hours_ago = time() - (24 * 60 * 60);

            $this->db->select('id');
            $this->db->from('tb_logs_visitor');
            $this->db->where('ip_address', $ip_address);
            $this->db->where('timestamp >', $twenty_four_hours_ago);
            $query = $this->db->get();

            // Jika tidak ditemukan, berarti unik
            return ($query->num_rows() == 0);
        }

        public function log_unique_visitor($ip_address)
        {
            $data = array(
                'ip_address'   => $ip_address,
                'timestamp'    => time(),
                'date_visited' => date('Y-m-d') 
            );
            
            $this->db->insert('tb_logs_visitor', $data);
            return $this->db->affected_rows();
        }
}

