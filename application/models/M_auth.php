<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {
    
    private $table_admin = 'admin_users'; 
    private $table_attempts = 'login_attempts'; 

    // 1. get_admin_by_username() -> Menggantikan cek_login() MD5 Anda yang lama
    public function get_admin_by_username($username)
    {
        $this->db->select('id, username, password'); 
        $this->db->where('username', $username);
        $query = $this->db->get($this->table_admin, 1);
        return $query->num_rows() == 1 ? $query->row() : FALSE; 
    }

    // 2. log_attempt() -> Mencatat kegagalan (Dipanggil saat login gagal)
    public function log_attempt($username, $ip_address)
    {
        $data = array(
            'ip_address' => $ip_address,
            'username' => $username,
            'time' => time()
        );
        $this->db->insert($this->table_attempts, $data);
    }

    // 3. check_limit() -> Fungsi yang bermasalah (Dipanggil di awal login)
    public function check_limit($ip_address, $limit = 5, $time_limit = 300) 
    {
        // Menghapus log lama
        $this->db->where('time <', time() - $time_limit)->delete($this->table_attempts);

        // Menghitung upaya yang tersisa
        $this->db->where('ip_address', $ip_address);
        $this->db->where('time >', time() - $time_limit);
        $count = $this->db->count_all_results($this->table_attempts);

        return ($count >= $limit);
    }
}