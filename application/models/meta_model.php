<?

class meta_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function show($id = null) {
        $this->db->from('metaKey');
        if ($id != '')
            $this->db->where('idMetaKey', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getMeta($id = null) {
        $this->db->from('metaKey');
        if ($id != null)
            $this->db->where('idMetaKey', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getMetaChef($tipo = null) {
        $this->db->from('metaKey');
        $this->db->join('tipoMeta', 'tipoMeta.idTipoMeta = metaKey.tipoMeta');
        $this->db->where('tipoMeta.idTipoMeta !=', 1);
        if ($tipo != null)
            $this->db->where('tipoMeta.idTipoMeta', $tipo);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getMetasCalificacion() {
        $this->db->from('metaKey')
                ->where('tipoMeta', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getMetasByTipo($idTipo) {
        $this->db->join('tipoMeta', 'tipoMeta.idTipoMeta = metaKey.tipoMeta')
                ->where('tipoMeta', $idTipo);
        $query = $this->db->get('metaKey');
        return $query->result_array();
    }

    public function add($data) {
        $newData = array(
            'nombreMeta' => $data['nombre'],
            'tipoMeta' => $data['tipoMeta'],
        );

        $this->db->insert('metaKey', $newData);
    }

    public function addMetaChef($metasChef) {
        $this->db->insert_batch('metaUsuario', $metasChef);
    }

    public function update($data) {
        $this->db->where('idMetaKey', $data['idMetaKey']);
        $this->db->update('metaKey', $data);
    }

    function delete($id) {
        $this->db->delete('metaKey', array('idMetaKey' => $id));
    }
    
    function is_unique($meta, $update) {
        $this->db->select('nombreMeta')
                ->where('nombreMeta', $meta);
        if($update !== FALSE) {
            $this->db->where('idMetaKey <>', $update);
        }
        $query = $this->db->get('metaKey');
        if($query->num_rows > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

?>