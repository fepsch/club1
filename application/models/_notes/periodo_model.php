<?php

class Periodos_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    public function add($data) {
        $this->db->insert('periodo', $data);
    }
    
    public function getPeriodo($id = NULL) {
        if($id !== NULL)
            $this->db->where('idPeriodo', $id);
        $this->db->get('periodos');
    }
}
?>
