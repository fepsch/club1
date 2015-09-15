<?

class login_model extends CI_Model {

    public function __construct() {
        $this->load->library('session');
        $this->load->database();
    }

    public function getLogin($username, $password) { //login
        $data = array(
            'mail' => $username,
            'password' => md5($password)
        );

        $query = $this->db->get_where('usuario', $data);

        return $query->result_array();
    }
    
    public function getFBLoginMail($username) { //login
        $data = array(
            'mail' => $username,
        );

        $query = $this->db->get_where('usuario', $data);

        return $query->result_array();
    }
    
    public function getFBLoginFBId($fbid) { //login
        $data = array(
            'fbid' => $fbid,
        );

        $query = $this->db->get_where('usuario', $data);

        return $query->result_array();
    }

    public function isLogged($username = NULL) {

        if($username !== NULL) {
            $un = $this->session->userdata('username');
            if($un && $username == $un) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
        else if (isset($this->session->userdata['username']))
            return TRUE;
        else
            return FALSE;
    }

    public function close() {
        return $this->session->sess_destroy();
    }

}

?>