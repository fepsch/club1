<?

class page_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function getPage($id = null) { //muestra usuarios de un perfil especifico o todos
        $this->db->from('page');
        if ($id != '')
            $this->db->where('idPage', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add($data) {
        $newData = array(
            'titulo' => $data['titulo'],
            'bajada' => $data['bajada'],
            'contenido' => $data['contenido'],
            'idUsuario' => $data['idUsuario'],
        );

        $this->db->insert('page', $newData);
    }

    function edit($data) {
        $newData = array(
            'titulo' => $data['titulo'],
            'bajada' => $data['bajada'],
            'contenido' => $data['contenido'],
        );
        $this->db->where('idPage', $data['idPage']);
        $this->db->update('page', $newData);
    }

    function delete($id) {
        $this->db->delete('page', array('idPage' => $id));
    }

}
?>