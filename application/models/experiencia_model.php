<?

class experiencia_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function getExperiencia($id = null) { //muestra usuarios de un perfil especifico o todos
        $this->db->from('experiencia');
        if ($id != '')
            $this->db->where('idExperiencia', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add($data) {
        $this->db->insert('experiencia', $data);
    }

    function edit($data) {
        $this->db->where('idExperiencia', $data['idExperiencia']);
        $this->db->update('experiencia', $data);
    }

    function delete($id) {
        $this->db->delete('experiencia', array('idExperiencia' => $id));
    }
    
    public function getExperienciasChef($id){
        $this->db->from('experiencia')
                ->where('idUsuario', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function countExperiencias() {
        $this->db->join('usuario u', 'u.idUsuario=e.idUsuario')
                 ->where('u.estado', 1);
         return $this->db->count_all_results('experiencia e');
        
    }
    
    public function getMinTimeChef($id) {
        $this->db->select('MIN(tiempo2) as tiempo2')
                ->where('idUsuario', $id)
                ->where('tiempo2 != 0')
                ->from('experiencia');
        $query = $this->db->get();
        return $query->result_array();
    }

}

?>