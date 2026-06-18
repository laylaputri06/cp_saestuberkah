<?php
class M_partner extends CI_Model {
    public function get_all_partner() {
        // Mengambil semua data partner secara acak
        $this->db->order_by('id_partner', 'RANDOM'); 
        return $this->db->get('tb_partner')->result_array();
    }
}