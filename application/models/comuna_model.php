<?php

class Comuna_model extends CI_Model {
    
    public function __construct() {
        $this->load->database();
    }
    
    public function getComuna($id){
        $this->db->where('idComuna', '$id');
        $query = $this->db->get('comuna');
        return $query->result_array();
    }
    
    public function getComunas() {
        $query = $this->db->get('comuna');
        return $query->result_array();
    }
}
?>
