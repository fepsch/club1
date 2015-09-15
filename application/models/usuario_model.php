<?

class usuario_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function getUser($mail) {
        $data = array('mail' => $mail);
        $query = $this->db->get_where('usuario', $data);
        return $query->result_array();
    }

    public function searchUserLike($mail) { //se cambia a nombre
        $this->db->from('usuario');
        $this->db->like('nombre', $mail);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function isUser($username) {
        $data = array('mail' => $username);
        $query = $this->db->get_where('usuario', $data);
        if ($query->num_rows() == 0)
            return false;
        else
            return true;
    }
    
    public function isUserFBNoMail($fbid) {
        $data = array('fbid' => $fbid);
        $query = $this->db->get_where('usuario', $data);
        if ($query->num_rows() == 0)
            return false;
        else
            return true;
    }

    public function getUserData($id = null) {
        $this->db->from('usuario');
        $this->db->where('idUsuario', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function showPerfil($id = null) { //muestra usuarios de un perfil especifico o todos
        $this->db->select('usuario.*');
        $this->db->from('usuario');
        if ($id != ''){
            $this->db->where('usuario.tipoUsuario', $id);
        }
        $this->db->join('tipoUsuario', 'usuario.tipoUsuario = tipoUsuario.idTipoUsuario');
        $this->db->select('tipoUsuario.nombre as tipoNombre');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function countPerfil($perfil) {
        $this->db->from('usuario')
                ->where('estado', 1);
        if ($perfil != '')
            $this->db->where('tipoUsuario', $perfil);
        $query = $this->db->count_all_results();
        return $query;
    }

    public function add($data) {
        $this->db->insert('usuario', $data);
    }

    public function getInsertedId() {
        return $this->db->insert_id();
    }

    public function edit($data) {
        $this->db->where('idUsuario', $data['idUsuario']);
        $this->db->update('usuario', $data);
    }

    public function delete($id) {
        $this->db->delete('usuario', array('idUsuario' => $id));
    }

    public function getDatosChef($id) {
        $this->db->join('metaUsuario mu', 'mu.idUsuario=u.idUsuario')
                ->where('u.idUsuario', $id)
                ->group_by('u.idUsuario');
        $query = $this->db->get('usuario u');
        return $query->result_array();
    }

    /**
     * @$fecha = FALSE
     * @$periodo = FALSE
     * @$nombreChef = FALSE
     * @$idComuna = FALSE
     * @$tag = FALSE
     * @dia = FALSE
     * @$orden = FALSE
     */
    public function getChefsDisponibles($data) {
        //TODO agregar a la query el día de semana, para buscar los chefs que atienden el día
        $sql = array(
            'select' => 'SELECT DISTINCT(u.idUsuario)',
            'from' => " FROM usuario u",
            'where' => " WHERE u.tipoUsuario = 2 AND u.estado = 1",
            'fin' => ''
        );

        $this->queryAgendaDisponible($data, $sql);
        $this->queryTags($data, $sql);
        $this->queryNombreChef($data, $sql);
        $this->subQuery($data, $sql);

        $select = $sql['select'];
        $from = $sql['from'];
        $where = $sql['where'];
        $fin = $sql['fin'];

        if ($data['orden'] !== FALSE) {
            switch ($data['orden']) {
                case 1: $order = " ORDER BY u.nombre asc";
                    $query = $this->db->query($select . $from . $where . $fin . $order);
                    break;
                case 2: $query = $this->db->query("SELECT u.idUsuario"
                            . " FROM usuario u"
                            . " JOIN metaUsuario mu ON mu.idUsuario=u.idUsuario"
                            . " WHERE mu.idMeta=4"
                            . " AND u.idUsuario IN ($select $from $where $fin)"
                            . " ORDER BY CAST(mu.dato AS DECIMAL) ASC");
                    break;
            }
        } else {
            $query = $this->db->query($select . $from . $where . $fin);
        }
        return $query->result_array();
    }

    function queryAgendaDisponible($data, &$sql) {
        if ($data['periodos'] !== FALSE OR $data['dia'] !== FALSE) {
            $sql['from'] .= " JOIN agendaChef ac ON ac.idChef=u.idUsuario";
            if ($data['periodos'] !== FALSE) {
                $sql['where'] .= " AND ac.idPeriodo IN ($data[periodos])";
            }
            if ($data['dia'] !== FALSE) {
                $sql['where'] .= " AND ac.idDiaAgenda = $data[dia]";
            }
        }
    }

    function queryTags($data, &$sql) {
        $tags = array();
        if ($data['comuna'] !== FALSE OR $data['tag'] !== FALSE) {
            $sql['from'] .= " JOIN metaUsuario mu ON mu.idUsuario=u.idUsuario";
            if ($data['comuna'] !== FALSE)
                $tags[] = $data['comuna'];
            if ($data['tag'] !== FALSE) {
                $tags = array_merge($tags, $data['tag']);
            }
            $in = implode(',', $tags);
            $sql['where'] .= " AND mu.idMeta IN ($in)";
            $conteo = count($tags);
            $sql['fin'] .= " GROUP BY u.idUsuario HAVING COUNT(*) = $conteo";
        }
    }

    function queryNombreChef($data, &$sql) {

        if ($data['nombreChef'] !== FALSE) {
            $sql['where'] .= " AND CONCAT(u.nombre, ' ', u.apellidoPaterno, ' ', u.apellidoMaterno) like '%$data[nombreChef]%'";
        }
    }

    function subQuery($data, &$sql) {
        if ($data['periodos'] !== FALSE) {
            $joinPeriodoChef = "JOIN agendaChef ac ON ac.idChef=u.idUsuario";
            $joinPeriodo = "JOIN periodos p ON p.idPeriodo=ac.idPeriodo"; // Para subquery.
            $wherePeriodo = "AND ac.idPeriodo IN ($data[periodos])";
            $subqPeriodo = "AND TIME(a.fecha) BETWEEN p.inicio AND p.fin"; // Para subquery.
        } else {
            $joinPeriodoChef = "";
            $joinPeriodo = "";
            $wherePeriodo = "";
            $subqPeriodo = "";
        }
        $sql['where'] .= " AND u.idUsuario NOT IN (SELECT DISTINCT(u.idUsuario)
                                  FROM usuario u
                                  JOIN experiencia e ON e.idUsuario=u.idUsuario
                                  JOIN actividad a ON a.idExperiencia=e.idExperiencia
                                  $joinPeriodoChef
                                  $joinPeriodo
                                  WHERE a.idEstado > 3
                                  $wherePeriodo
                                  AND DATE(a.fecha) = DATE('$data[fecha]')
                                  $subqPeriodo)";
    }

    public function chefsCarrusel() {
        $query = $this->db->query("SELECT u.idUsuario, u.nombre, u.apellidoPaterno, u.avatar, mu.dato, u.link
                                    FROM usuario u 
                                    JOIN metaUsuario mu ON mu.idUsuario=u.idUsuario
                                    WHERE u.idUsuario IN (SELECT idUsuario FROM metaUsuario WHERE idMeta = 57)
                                    AND u.tipoUsuario = 2
                                    AND mu.idMeta = 58
                                    UNION
                                    SELECT u.idUsuario, u.nombre, u.apellidoPaterno, u.avatar, '' as dato, '' as link
                                    FROM usuario u
                                    JOIN metaUsuario mu ON mu.idUsuario=u.idUsuario
                                    WHERE mu.idMeta = 57
                                    AND mu.idUsuario NOT IN (SELECT u.idUsuario
                                                                FROM usuario u 
                                                                JOIN metaUsuario mu ON mu.idUsuario=u.idUsuario
                                                                WHERE u.idUsuario IN (SELECT idUsuario FROM metaUsuario WHERE idMeta = 57)
                                                                AND u.tipoUsuario = 2
                                                                AND mu.idMeta = 58)");
        return $query->result_array();
    }

    public function getAutocomplete($string) {

        $sql = "SELECT CONCAT(u.nombre, ' ', u.apellidoPaterno, ' ', u.apellidoMaterno) as nombreFull
            FROM usuario u
            WHERE CONCAT(u.nombre, ' ', u.apellidoPaterno, ' ', u.apellidoMaterno) like '%$string%'
            AND u.tipoUsuario = 2";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getUserToken($mail, $token) {
        $this->db->where('mail', $mail)
                ->where('token', $token);
        $query = $this->db->get('usuario');
        return $query->result_array();
    }

    public function getUserTokenAcs($mail, $token) {
        $this->db->where('mail', $mail)
                ->where('tkn_acs', $token);
        $query = $this->db->get('usuario');
        return $query->result_array();
    }
    
    public function getIdChefByLink($link) {
        $this->db->select('idUsuario')
                ->where('link', $link)
                ->where('estado', 1);
        $query = $this->db->get('usuario');
        return $query->result_array();
    }
    
    function link_is_unique($link, $update) {
        $this->db->select('link')
                ->where('link', $link);
        if($update !== FALSE) {
            $this->db->where('idUsuario <>', $update);
        }
        $query = $this->db->get('usuario');
        if($query->num_rows > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

?>