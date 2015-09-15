<?php

class tipo_meta_model extends CI_Model {
    
    public function __construct() {
        $this->load->database();
    }
    
    public function getTiposMeta(){
        $query = $this->db->get('tipoMeta');
        return $query->result_array();
    }
    
    public function getTipoMeta($id) {
        $this->db->from('tipoMeta')
                ->where('idTipoMeta', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>
