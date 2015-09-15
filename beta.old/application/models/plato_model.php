<?

class plato_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function getPlato($id = null) { //muestra usuarios de un perfil especifico o todos
        $this->db->from('plato');
        if ($id != '')
            $this->db->where('idPlato', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getPlatosExperiencia($id = null) { //muestra usuarios de un perfil especifico o todos
        $this->db->from('plato');  
        $this->db->where('idExperiencia', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add($data) {
        $newData = array(
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'imagen' => $data['imagen'],
            'idExperiencia' => $data['idExperiencia'],
        );

        $this->db->insert('plato', $newData);
    }

    function edit($data) {
        $newData = array(
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'imagen' => $data['imagen'],
            'idExperiencia' => $data['idExperiencia'],
        );
        $this->db->where('idPlato', $data['idPlato']);
        $this->db->update('plato', $newData);
    }

    function delete($id) {
        $this->db->delete('plato', array('idPlato' => $id));
    }

}

?>