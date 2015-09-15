<?
class estado_model extends CI_Model{
	
	public function __construct(){
		$this->load->database();
    }
	
	public function show($id = null){
		$this->db->from('usuario');
		if ($id != '')
			$this->db->where('idUsuario',$id);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getEstado($id = null) {
	
            if(isset($id)){
                $data = array(
			'idEstadoActividad' => $id,
                    );
		$query = $this->db->get_where('estadoActividad',$data);
            }else
                $query = $this->db->get('estadoActividad');
            
		return $query->result_array();
	}
	
}
?>