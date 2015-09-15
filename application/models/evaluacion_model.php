<?

class Evaluacion_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    /**
     * Función para retornar los campos evaluados de la actividad
     * y los campos que falten por evaluar
     */
    public function getEvalActividad($id = null) {
        $query = $this->db->query("SELECT idMeta AS idMetaKey, nombreMeta, nota, fecha
            FROM evaluacion
            JOIN metaKey
            ON metaKey.idMetaKey=evaluacion.idMeta
            WHERE evaluacion.idActividad = ?
            UNION
            SELECT idMetaKey, nombreMeta, NULL nota, NULL AS fecha
            FROM metaKey
            WHERE metaKey.tipoMeta = ?
            AND metaKey.idMetaKey NOT IN (SELECT idMeta FROM evaluacion WHERE evaluacion.idActividad = ? )
            ORDER BY idMetaKey", array($id, 1, $id)
        );
        return $query->result_array();
    }
    
    public function actividadEvaluada($id) {
        $this->db->from("evaluacion")
                ->where('idActividad', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }

    public function add($data) {
        $this->db->insert('evaluacion', $data);
    }

    public function update($data) {
        $this->db->where('idActividad', $data['idActividad'])
                ->where('idMeta', $data['idMeta'])
                ->update('evaluacion', $data);
    }

    public function addOrUpdate($data) {
        $this->db->where(array(
            'idActividad' => $data['idActividad'],
            'idMeta' => $data['idMeta']
        ));
        $query = $this->db->get('evaluacion');
        if ($query->num_rows() == 0) {
            $this->add($data);
        } else {
            $query = $query->result_array();
            if ($query[0]['nota'] != $data['nota'])
                $this->update($data);
        }
    }

    /**
     * Evaluaciones para la vista general del chef
     * */
    public function getEvaluacionesChef($id) {
        $this->db->select('e.idMeta, m.nombreMeta, SUM(e.nota) nota, COUNT(e.nota) conteo')
                ->from('evaluacion e')
                ->join('actividad a', 'a.idActividad=e.idActividad')
                ->join('experiencia ex', 'ex.idExperiencia=a.idExperiencia')
                ->join('metaKey m', 'm.idMetaKey=e.idMeta')
                ->where('ex.idUsuario', $id)
                ->group_by('e.idMeta');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function insertBatch($evaluaciones) {
        $this->db->insert_batch('evaluacion', $evaluaciones);
    }

}

?>