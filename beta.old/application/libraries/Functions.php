<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Functions {
    
    /**
     * 
     * @param string $fecha
     * @return date en formato 'Y-m-d'
     */
    public function dateMySql($fecha) {
        if ($fecha != '' && strpos($fecha, '/'))
            $fecha = $this->fechaLineas($fecha);
        return date('Y-m-d', strtotime($fecha));
    }
    
    /**
     * 
     * @param type $fecha
     * @return date en formato Y-m-d H:i
     */
    public function dateTimeMySql($fecha) {
        if (($fecha != '') && strpos($fecha, '/')!== FALSE)
            $fecha = $this->fechaLineas($fecha);
        return date('Y-m-d H:i', strtotime($fecha));
    }
    
    public function dateTimeSecsMySql($fecha) {
        if (($fecha != '') && (strpos($fecha,'/') !== FALSE))
            $fecha = $this->fechaLineas($fecha);
        return date('Y-m-d H:i:s', strtotime($fecha));
    }

    function fechaLineas($fecha) {
        $fecha = str_replace('/', '-', $fecha);
        return $fecha;
    }
    
    function meta_a_bd($str) {
        return strtolower(str_replace(' ', '_', $str));
    }
    
    function meta_a_ui($str) {
        return ucwords(str_replace('_', ' ', $str));
    }
}
