<?php

class Dia_agenda_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    public function add($data) {
        $this->db->insert('diaAgenda', $data);
    }
    
    public function get($id = NULL) {
        if($id !== NULL)
            $this->db->where('idDiaAgenda', $id);
        $query = $this->db->get('diaAgenda da');
        return $query->result_array();
    }
    
    public function del($id) {
        $this->db->delete('diaAgenda', array('idDiaAgenda' => $id));
    }
    
    public function getIdDiaFecha($fecha) {
        $this->db->select("idDiaAgenda")
                ->where("diaMySql=DATE_FORMAT('$fecha', '%w')");
        $query = $this->db->get("diaAgenda");
        return $query->result_array();
    }
}
?>
