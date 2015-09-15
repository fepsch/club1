<?
class registro_model extends CI_Model{
    
	public function __construct(){
		$this->load->database();
    } 
   
    public function getUser($username){
		$data = array(
			'mail' => $username,
		);
		$query = $this->db->get_where('usuario',$data);
		return $query->result_array();
    }  
   
    public function addUser($data){
		$newData = array(
			'mail' => $data['mail'],
			'nombre' => $data['nombre'],
			'apellidoPaterno' => $data['apellidoPaterno'],
			'apellidoMaterno' => $data['apellidoMaterno'],
			'password' => md5($data['password']),
			'fbid' => $data['fbid'],
			//'avatar' => $data['avatar'],
		);
		
		$this->db->insert('usuario', $newData);
	}
	
	function editUser($data){
		$newData = array(
			'mail' => $data['mail'],
			'nombre' => $data['nombre'],
			'apellidoPaterno' => $data['apellidoPaterno'],
			'apellidoMaterno' => $data['apellidoMaterno'],
			'password' => md5($data['password']),
			//'fbid' => $data['fbid'],
			//'avatar' => $data['avatar'],
		);
			$this->db->where('idItem',$data['idUsuario']);
			$query = $this->db->update('usuario', $newData);
	}
	
	function eliminarItem($id){
		//$this->db->delete('usuario', array('idUsuario'=>$id));		
	}
	
}
?>