<?php

class Agenda_chef_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    public function add($data) {
        $this->db->insert('agendaChef', $data);
    }
    
    public function addBatch($data) {
        $this->del($data[0]['idChef']);
        $this->db->insert_batch('agendaChef', $data);
    }
    
    public function get($id = NULL, $periodo = NULL) {
        if($id !== NULL)
            $this->db->where('idChef', $id);
        if($periodo !== NULL)
            $this->db->where('ac.idPeriodo', $periodo);
        $this->db->join('periodos p', 'p.idPeriodo=ac.idPeriodo');
        $query = $this->db->get('agendaChef ac');
        return $query->result_array();
    }
    
    public function periodosDisponiblesDia($idChef, $fecha) {
        $sql = "SELECT DISTINCT(p.idPeriodo)
                FROM periodos p
                JOIN agendaChef ac ON ac.idPeriodo=p.idPeriodo
                JOIN diaAgenda da ON da.idDiaAgenda=ac.idDiaAgenda
                WHERE da.diaMySql= DATE_FORMAT('$fecha', '%w')
                AND ac.idChef = $idChef
                AND p.idPeriodo 
                NOT IN(SELECT t2.idPeriodo
                        FROM (SELECT idPeriodo, COUNT( idPeriodo ) AS totalPeriodo
                              FROM (SELECT p.idPeriodo, CAST( a.fecha AS DATE ) AS fecha, ac.idChef
                                    FROM periodos p
                                    JOIN agendaChef ac ON ac.idPeriodo = p.idPeriodo
                                    JOIN experiencia e ON e.idUsuario = ac.idChef
                                    JOIN actividad a ON a.idExperiencia = e.idExperiencia
                                    WHERE a.idEstado >3
                                    AND e.idUsuario=$idChef
                                    AND DATE( a.fecha ) = DATE(  '$fecha' ) 
                                    AND TIME( a.fecha ) 
                                    BETWEEN p.inicio
                                    AND p.fin
                                    AND ac.idDiaAgenda = CAST( DATE_FORMAT( a.fecha,  '%w' ) AS DECIMAL ) 
                                    UNION 
                                    SELECT idPeriodo, fecha, idChef
                                    FROM agendaNoDisponible
                                    WHERE DATE( fecha ) = DATE(  '$fecha' )
                                   )t
                              GROUP BY idPeriodo
                              )t2,
                                  (SELECT idDiaAgenda, idPeriodo, COUNT( ac.idPeriodo ) totalPeriodo
                                    FROM agendaChef ac
                                    WHERE ac.idDiaAgenda = CAST( DATE_FORMAT(  '$fecha',  '%w' ) AS DECIMAL ) 
                                    AND ac.idChef = $idChef
                                    GROUP BY idDiaAgenda, idPeriodo
                               )t3
                        WHERE t2.totalPeriodo=t3.totalPeriodo
                        AND t2.idPeriodo=t3.idPeriodo)
                ORDER BY inicio";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function periodosDisponiblesDiaForm($fecha) {
        $sql = "SELECT DISTINCT(p.idPeriodo)
                FROM periodos p
                JOIN agendaChef ac ON ac.idPeriodo=p.idPeriodo
                JOIN diaAgenda da ON da.idDiaAgenda=ac.idDiaAgenda
                WHERE da.diaMySql= DATE_FORMAT('$fecha', '%w')
                AND p.idPeriodo 
                NOT IN(SELECT t2.idPeriodo
                        FROM (SELECT idPeriodo, COUNT( idPeriodo ) AS totalPeriodo
                              FROM (SELECT p.idPeriodo, CAST( a.fecha AS DATE ) AS fecha, ac.idChef
                                    FROM periodos p
                                    JOIN agendaChef ac ON ac.idPeriodo = p.idPeriodo
                                    JOIN experiencia e ON e.idUsuario = ac.idChef
                                    JOIN actividad a ON a.idExperiencia = e.idExperiencia
                                    WHERE a.idEstado >3
                                    AND DATE( a.fecha ) = DATE(  '$fecha' ) 
                                    AND TIME( a.fecha ) 
                                    BETWEEN p.inicio
                                    AND p.fin
                                    AND ac.idDiaAgenda = CAST( DATE_FORMAT( a.fecha,  '%w' ) AS DECIMAL ) 
                                    UNION 
                                    SELECT idPeriodo, fecha, idChef
                                    FROM agendaNoDisponible
                                    WHERE DATE( fecha ) = DATE(  '$fecha' )
                                   )t
                              GROUP BY idPeriodo
                              )t2,
                                  (SELECT idDiaAgenda, idPeriodo, COUNT( ac.idPeriodo ) totalPeriodo
                               FROM agendaChef ac
                               WHERE ac.idDiaAgenda = CAST( DATE_FORMAT(  '$fecha',  '%w' ) AS DECIMAL ) 
                               GROUP BY idDiaAgenda, idPeriodo
                               )t3
                        WHERE t2.totalPeriodo=t3.totalPeriodo
                        AND t2.idPeriodo=t3.idPeriodo)
                ORDER BY inicio";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    //TODO: crear una query que traiga los periodos que se hayan tomado el dia
    // que se está consultando, si es posible, descartar dias completos
    
    public function checkHoraDisponible($idChef, $fecha) {
        $sql = "SELECT p.idPeriodo
                FROM periodos p
                JOIN agendaChef ac ON ac.idPeriodo=p.idPeriodo
                JOIN experiencia e ON e.idUsuario=ac.idChef
                JOIN actividad a ON a.idExperiencia=e.idExperiencia
                WHERE e.idUsuario = $idChef
                AND p.inicio <= TIME('$fecha')
                AND p.fin > TIME('$fecha')
                AND p.inicio <= TIME(a.fecha)
                AND p.fin > TIME(a.fecha)
                AND a.idEstado > 3
                AND DATE(a.fecha) = DATE('$fecha')";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function del($id) {
        $this->db->delete('agendaChef', array('idChef' => $id));
    }
    
    public function agendaChef($id) {
        //Union, trae los periodos asociados al chef, como los que no para seleccionarlos en el admin
        $query = $this->db->query("(
                                    SELECT ac.idChef, ac.idPeriodo, inicio, fin, da.idDiaAgenda, da.nombreDiaAgenda
                                    FROM agendaChef ac
                                    JOIN periodos p ON p.idPeriodo = ac.idPeriodo
                                    JOIN diaAgenda da ON da.idDiaAgenda = ac.idDiaAgenda
                                    WHERE ac.idChef =$id
                                    AND ac.idPeriodo = p.idPeriodo
                                    )
                                    UNION 
                                    (
                                    SELECT NULL AS idChef, p.idPeriodo, p.inicio, p.fin, da.idDiaAgenda, da.nombreDiaAgenda
                                    FROM periodos p, diaAgenda da
                                    WHERE NOT EXISTS (SELECT * 
                                                      FROM agendaChef ac
                                                      WHERE ac.idChef =$id
                                                      AND ac.idPeriodo = p.idPeriodo
                                                      AND ac.idDiaAgenda = da.idDiaAgenda
                                                      )
                                    )
                                    ORDER BY inicio, fin, idDiaAgenda");
        return $query->result_array();
    }
    
    public function diasSemanaDisponibles($idChef = FALSE) {
        $this->db->select('DISTINCT(ac.idDiaAgenda)')
                ->from('agendaChef ac');
        if($idChef !== FALSE) {
            $this->db->where('ac.idChef', $idChef);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function diasNoDisponibles($idChef = FALSE, $fecha = FALSE) {
        if ($fecha === FALSE) {
            $condicion_mes1 = "AND DATE_FORMAT(ad.fecha, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')";
            $condicion_mes2 = "AND DATE_FORMAT(a.fecha, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')";
        } else {
            $condicion_mes1 = "AND DATE_FORMAT(ad.fecha, '%Y-%m') = DATE_FORMAT('$fecha', '%Y-%m')";
            $condicion_mes2 = "AND DATE_FORMAT(a.fecha, '%Y-%m') = DATE_FORMAT('$fecha', '%Y-%m')";
        }
        
        $query = $this->db->query("SELECT idChef, fecha, t2.totalPeriodo, t2.diaMySql
                                    FROM (SELECT idChef, fecha, COUNT( idPeriodo ) totalPeriodo, DATE_FORMAT( fecha,  '%w' ) diaMySql
                                        FROM (SELECT ad.idChef, ad.fecha, ad.idPeriodo
                                                FROM agendaNoDisponible ad
                                                WHERE idChef = $idChef
                                                AND CAST( fecha AS DATE ) > CURDATE( ) 
                                                $condicion_mes1
                                                UNION 
                                                SELECT e.idUsuario AS idChef, CAST( a.fecha AS DATE ) AS fecha, p.idPeriodo AS idPeriodo
                                                FROM actividad a
                                                JOIN experiencia e ON e.idExperiencia = a.idExperiencia
                                                JOIN agendaChef ac ON ac.idChef = e.idUsuario
                                                JOIN periodos p ON p.idPeriodo = ac.idPeriodo
                                                JOIN diaAgenda da ON da.idDiaAgenda = ac.idDiaAgenda
                                                WHERE e.idUsuario = $idChef
                                                $condicion_mes2
                                                AND a.idEstado > 3
                                                AND CAST( a.fecha AS DATE ) > CURDATE( ) 
                                                AND CAST( a.fecha AS TIME ) BETWEEN p.inicio AND p.fin
                                                AND da.idDiaAgenda = CAST( DATE_FORMAT( a.fecha,  '%w' ) AS DECIMAL ) 
                                            )t
                                        GROUP BY fecha
                                    )t2, 
                                    (SELECT COUNT( ac.idPeriodo ) totalPeriodo, da.diaMySql
                                            FROM  agendaChef ac
                                            JOIN diaAgenda da ON da.idDiaAgenda = ac.idDiaAgenda
                                            WHERE ac.idChef = $idChef
                                            GROUP BY da.idDiaAgenda
                                    )t3
                                    WHERE t2.totalPeriodo = t3.totalPeriodo
                                    AND t2.diaMySql = t3.diaMySql");
        return $query->result_array();
    }
    
    public function diasNoDisponiblesBusqueda($fecha = FALSE) {
        if ($fecha === FALSE) {
            $condicion_mes1 = "AND DATE_FORMAT(ad.fecha, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')";
            $condicion_mes2 = "AND DATE_FORMAT(a.fecha, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')";
        } else {
            $condicion_mes1 = "AND DATE_FORMAT(ad.fecha, '%Y-%m') = DATE_FORMAT('$fecha', '%Y-%m')";
            $condicion_mes2 = "AND DATE_FORMAT(a.fecha, '%Y-%m') = DATE_FORMAT('$fecha', '%Y-%m')";
        }
        $query = $this->db->query("SELECT fecha, t2.totalPeriodo, t2.diaMySql
                                    FROM (SELECT fecha, COUNT( idPeriodo ) totalPeriodo, DATE_FORMAT( fecha,  '%w' ) diaMySql
                                        FROM (SELECT ad.fecha, ad.idPeriodo
                                                FROM agendaNoDisponible ad
                                                WHERE CAST( fecha AS DATE ) > CURDATE( ) 
                                                $condicion_mes1
                                                UNION 
                                                SELECT CAST( a.fecha AS DATE ) AS fecha, p.idPeriodo AS idPeriodo
                                                FROM actividad a
                                                JOIN experiencia e ON e.idExperiencia = a.idExperiencia
                                                JOIN agendaChef ac ON ac.idChef = e.idUsuario
                                                JOIN periodos p ON p.idPeriodo = ac.idPeriodo
                                                JOIN diaAgenda da ON da.idDiaAgenda = ac.idDiaAgenda
                                                WHERE CAST( a.fecha AS DATE ) > CURDATE( ) 
                                                $condicion_mes2
                                                AND CAST( a.fecha AS TIME ) 
                                                BETWEEN p.inicio
                                                AND p.fin
                                                AND da.idDiaAgenda = CAST( DATE_FORMAT( a.fecha,  '%w' ) AS DECIMAL ) 
                                            )t
                                        GROUP BY fecha
                                    )t2, (SELECT COUNT( ac.idPeriodo ) totalPeriodo, da.diaMySql
                                            FROM  agendaChef ac
                                            JOIN diaAgenda da ON da.idDiaAgenda = ac.idDiaAgenda
                                            GROUP BY da.idDiaAgenda
                                    )t3
                                    WHERE t2.totalPeriodo = t3.totalPeriodo
                                    AND t2.diaMySql = t3.diaMySql");
        return $query->result_array();
    }
    
    public function getAgendaPorFecha($data) {
        $query = $this->db->query("SELECT ac.idPeriodo, ac.idChef, '$data[fecha]' AS fecha
                            FROM agendaChef ac
                            JOIN diaAgenda da ON da.idDiaAgenda=ac.idDiaAgenda
                            WHERE ac.idChef = $data[idChef]
                            AND da.diaMySql=DATE_FORMAT('$data[fecha]','%w')");
        return $query->result_array();
    }
    
    public function agendaNoDisponible($idChef = FALSE) {
        if($idChef !== FALSE) {
            $this->db->where('idChef', $idChef);
        }
        $this->db->select('DISTINCT(fecha)')
                ->order_by('fecha');
        $query = $this->db->get('agendaNoDisponible');
        return $query->result_array();
    }
    
    public function deleteDiaNoDisponible($data) {
        $this->db->delete('agendaNoDisponible', array('idChef' => $data['idChef'], 'fecha' => $data['fecha']));
    }
    
    public function setDiasNoDisponibles($data){
        $this->db->insert_batch('agendaNoDisponible', $data);
    }
    
    public function diasNoDisponiblesProximos($id) {
        
    }
}
?>
