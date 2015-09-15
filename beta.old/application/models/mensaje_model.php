<?

class mensaje_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function show($id = null) {
        $this->db->from('mensaje');
        if ($id != '')
            $this->db->where('idmensaje', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getMensaje($id = null) {
        $data = array(
            'idmensaje' => $id,
        );
        $query = $this->db->get_where('mensaje', $data);
        return $query->result_array();
    }

    public function add($data) {
        $this->db->insert('mensaje', $data);
    }

    public function update($data) {
        $this->db->where('idActividad', $data['idActividad'])
                ->where('reclamo', $data['reclamo'])
                ->where('comentario', $data['comentario'])
                ->update('mensaje', $data);
    }

    /* function edit($data){
      $newData = array(
      'idActividad' => $data['idActividad'],
      'fecha' => $data['fecha'],
      'titulo' => $data['titulo'],
      'contenido' => $data['contenido'],
      'reclamo' => $data['reclamo'],
      'leido' => $data['leido'],
      );
      $this->db->where('idmensaje',$data['idmensaje']);
      $query = $this->db->update('mensaje', $newData);
      } */

    //leer
    //mensajesUsuario
    //mensajessinleer(id)

    function leerMensaje($id) {
        $newData = array(
            'leido' => '1',
        );
        $this->db->where('idmensaje', $id);
        $query = $this->db->update('mensaje', $newData);
    }

    function mensajesActividad($id) {
        $this->db->from('mensaje m')
                ->join('actividad a', 'a.idActividad=m.idActividad')
                ->join('experiencia e', 'e.idExperiencia=a.idExperiencia')
                ->join('usuario u', 'u.idUsuario=m.idUsuario')
                ->where('reclamo', 0)
                ->where('comentario', 0)
                ->where('a.idActividad', $id)
                ->order_by('m.fecha', 'desc');
        ;
        $query = $this->db->get();
        return $query->result_array();
    }

    function comentariosActividad($id) {
        $this->db->from('mensaje m')
                ->join('actividad a', 'a.idActividad=m.idActividad')
                ->join('experiencia e', 'e.idExperiencia=a.idExperiencia')
                ->join('usuario u', 'u.idUsuario=m.idUsuario')
                ->where('reclamo', 0)
                ->where('comentario', 1)
                ->where('a.idActividad', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function mensajesUsuario($id = null, $tipo = NULL) {
        $this->db->from('mensaje');
        $this->db->where('idUsuario', $id);
        if ($tipo !== NULL) {
            switch ($tipo) {
                case 1: $this->db->where('reclamo', 1);
                    break;
                case 2: $this->db->where('comentario', 1);
                    break;
            }
        } else {
            $this->db->where('reclamo', 0);
            $this->db->where('comentario', 0);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function mensajesParaChef($id, $reclamo = null) {
        $this->db->from('mensaje')
                ->join('actividad', 'actividad.idActividad=mensaje.idActividad')
                ->join('experiencia', 'experiencia.idExperiencia=actividad.idExperiencia')
                ->where('experiencia.idUsuario', $id);
        if ($reclamo == 1)
            $this->db->where('reclamo', $reclamo);
        $msgs = $this->db->get();
        return $msgs->result_array();
    }

    function mensajesSinLeer($id) {
        $data = array(
            'leido' => '0',
            'idUsuario' => $id,
        );
        $this->db->from('mensaje');
        $query = $this->db->get();
        return $query->result();
    }

    function delete($id) {
        $this->db->delete('mensaje', array('idmensaje' => $id));
    }

    public function addOrUpdate($data) {
        $this->db->where('idActividad', $data['idActividad'])
                ->where('comentario', 1);
        $query = $this->db->get('mensaje');
        if ($query->num_rows() == 0) {
            $this->add($data);
        } else {
            $this->update($data);
        }
    }

    public function comentariosParaChef($id) {
        $this->db->select('m.idMensaje, m.idUsuario, m.idActividad, m.fecha, m.titulo, m.contenido, m.reclamo, m.comentario, m.leido')
                ->from('mensaje m')
                ->join('actividad', 'actividad.idActividad=m.idActividad')
                ->join('experiencia', 'experiencia.idExperiencia=actividad.idExperiencia')
                ->where('comentario', 1)
                ->where('experiencia.idUsuario', $id);
        $msgs = $this->db->get();
        return $msgs->result_array();
    }

}

?>