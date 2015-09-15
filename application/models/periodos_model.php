<?php

class Periodos_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function add($data) {
        $this->db->insert('periodos', $data);
    }

    public function get($id = NULL) {
        if ($id !== NULL)
            $this->db->where('idPeriodo', $id);
        $query = $this->db->get('periodos');
        return $query->result_array();
    }

    public function getPeriodoHora($hora) {
        $this->db->where('inicio <= ', $hora)
                ->where('fin >= ', $hora);
        $query = $this->db->get('periodos');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function update($data) {
        $this->db->where('idPeriodo', $data['idPeriodo']);
        if ($this->db->update('periodos', $data))
            return TRUE;
        else
            return FALSE;
    }

    public function del($id){
        $this->db->delete('periodos', array('idPeriodo' => $id));
        //echo "eliminado";
    }

    public function periodoActivo($idPeriodo){
        
        $this->db->where('idPeriodo',$idPeriodo);
        $query = $this->db->get('agendaChef');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>
