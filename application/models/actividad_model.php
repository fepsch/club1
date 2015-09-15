<?

class actividad_model extends CI_Model {

    public function __construct() {
        $this->load->database();
        $this->load->dbutil();
        $this->load->helper('file');
    }

    public function getActividad($id) {


        $data = array(
            'idActividad' => $id,
        );
        $query = $this->db->get_where('actividad', $data);
        return $query->result_array();
    }


    public function getActividadFull($id = '') {

        /*
        $actividad = $this->actividad_model->getActividad($id);
        $estado = $this->estado_model->getEstado($actividad[0]['idEstado']);
        $actividad[0]['estado'] = $estado[0]['nombre'];
        $usuario = $this->usuario_model->getUserData($actividad[0]['idUsuarioCliente']);
        $actividad[0]['usuario'] = $usuario[0];
        $experiencia = $this->experiencia_model->getExperiencia($actividad[0]['idExperiencia']);
        $actividad[0]['experiencia'] = $experiencia[0];
        $chef = $this->usuario_model->getUserData($experiencia[0]['idUsuario']);
        $actividad[0]['chef'] = $chef[0];
        $data['actividad'] = $actividad[0];
        */

        $this->db->select('actividad.*');
        $this->db->select('estadoActividad.nombre  AS nombreEstado ');
        $this->db->select('usuario.nombre  AS nombreUsuario ');
        
        $this->db->select('experiencia.nombre  AS nombreExperiencia');
    
        $this->db->from('actividad'); 
        
        $this->db->join('usuario', 'usuario.idUsuario = actividad.idUsuarioCliente');
             
        $this->db->join('estadoActividad', 'estadoActividad.idEstadoActividad = actividad.idEstado');
        $this->db->join('experiencia', 'experiencia.idExperiencia = actividad.idExperiencia');
        
        if($id != '')
            $this->db->where('idActividad',$id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }


    public function showActividad($data, $join, $dataUsuario = FALSE,$down='') {

        $this->db->select('actividad.*');
        $this->db->select('estadoActividad.nombre  AS nombreEstado ');
        $this->db->select('usuario.nombre  AS nombreUsuario ');
        $this->db->select('experiencia.nombre  AS nombreExperiencia');

        $this->db->join('usuario', 'usuario.idUsuario = actividad.idUsuarioCliente');
        $this->db->join('estadoActividad', 'estadoActividad.idEstadoActividad = actividad.idEstado');
        $this->db->join('experiencia', 'experiencia.idExperiencia = actividad.idExperiencia');

        $this->db->from('actividad');
        if($join !== NULL)
            $this->db->join($join[0], $join[1]);
        $this->db->order_by('fecha', 'desc');
        $this->db->where($data);
        //if($dataUsuario) {
        //    $this->db->join('usuario', 'usuario.idUsuario=actividad.idUsuarioCliente');
        //}
        $query = $this->db->get();

        $csv = $this->dbutil->csv_from_result($query); //Hay que cambiar esto por un metodo con destroy
            if ( ! write_file('csv/'.$down.'.csv', $csv,'w+'))
            {
                 echo 'Error al escribir archivo';
            }
            else
            {
                 //echo 'File written!';
            }

        //if($down != ''){
        //    return $query;
        //}
        return $query->result_array();
    }

    /* 	Type	Collation	Attributes	Null	Default	Extra	Action
      idActividad	int(11)			No	None	AUTO_INCREMENT	 Browse distinct values	 Change	 Drop	 Primary	 Unique	 Index	Fulltext
      idUsuarioCliente	int(11)			Yes	NULL		 Browse distinct values	 Change	 Drop	 Primary	 Unique	 Index	Fulltext
      idUsuarioChef	int(11)			Yes	NULL		 Browse distinct values	 Change	 Drop	 Primary	 Unique	 Index	Fulltext
      fecha	datetime			Yes	NULL		 Browse distinct values	 Change	 Drop	 Primary	 Unique	 Index	Fulltext
      valor	int(11)			No	None		 Browse distinct values	 Change	 Drop	 Primary	 Unique	 Index	Fulltext
      pasajeros	int(11)			No	None		 Browse distinct values	 Change	 Drop	 Primary	 Unique	 Index	Fulltext
      evaluacion	int(11)			Yes	NULL		 Browse distinct values	 Change	 Drop	 Primary	 Unique	 Index	Fulltext
      idEstado	int(11)			Yes	NULL		 Browse distinct values	 Change	 Drop	 Primary	 Unique	 Index	Fulltext
     */

    public function add($data) {
    $this->db->insert('actividad', $data);
    }

    public function getInsertedId() {
        return $this->db->insert_id();
    }
    function update($data) {
        $this->db->where('idActividad', $data['idActividad']);
        $this->db->update('actividad', $data);
    }

    function delete($id) {
        $this->db->delete('actividad', array('idActividad' => $id));
    }

    function actividadesUsuario($id, $estado = NULL) {
        $this->db->from('actividad')
                ->join('estadoActividad', 'estadoActividad.idEstadoactividad=actividad.idEstado')
                ->where('idUsuarioCliente', $id)
                ->order_by('fecha', 'desc');
        if($estado !== NULL)
            $this->db->where('idEstado', $estado);
        else
            $this->db->where('idEstado > ', 2);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function actividadesChef($id) {
        $this->db->from('actividad')
                ->join('experiencia', 'experiencia.idExperiencia=actividad.idExperiencia')
                ->join('estadoActividad', 'estadoActividad.idEstadoactividad=actividad.idEstado')
                ->where('experiencia.idUsuario', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function actividadesFinalizadas() {
        $this->db->select('a.idActividad, a.idEstado, u.idUsuario, u.mail')
                ->where('a.idEstado', 4)
                ->where('DATE(fecha) <',date('Y-m-d', time()))
                ->join('usuario u', 'a.idUsuarioCliente=u.idUsuario');
        $query = $this->db->get('actividad a');
        return $query->result_array();
    }

}

?>