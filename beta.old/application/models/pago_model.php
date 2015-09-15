<?
class pago_model extends CI_Model{
	
	public function __construct(){
		$this->load->database();
    } 
	
	public function getPago($id = null) {
		$data = array(
			'idPago' => $id,
		);
		$query = $this->db->get_where('pagoActividad',$data);
		return $query->result_array();
	}
	
	public function add($data){
		$newData = array(
			'idActividad' => $data['idActividad'],
			'respuesta' => $data['respuesta'],
			'idAutorizacion' => $data['idAutorizacion'],
			'finalTarjeta' => $data['finalTarjeta'],
			'fecha' => date('Y-m-d'),
		);
		
		$this->db->insert('pagoActividad', $newData);
	}
        
        function pagosUsuario($id)
        {
            $this->db->from('pagoActividad')
                    ->join('actividad', 'pagoActividad.idActividad=actividad.idActividad')
                    ->where('idUsuarioCliente',$id);
                    
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function validaActividadPagada($idActividad) {
            $this->db->where('idActividad', $idActividad)
                    ->where('respuesta', 0);
            $query = $this->db->get('pagoActividad');
            if($query->num_rows() == 1) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
}
?>