<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Actividades {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscar($modulo, $operacion, $usuario, $fecha) {
        $cmodulo = ($modulo == "TODOS") ? "" : $modulo;
        $coperacion = ($operacion == "TODAS") ? "" : $operacion;
        $cfecha = ($fecha) ? "AND CAST(afecha as date) = CAST('{$fecha}' as date)" : "";
        $consulta = "SELECT * FROM vwlog_actividad WHERE amodulo LIKE ? AND aoperacion LIKE ? AND ulegajo LIKE ? {$cfecha}";
        $datos = array('%' . $cmodulo . '%', '%' . $coperacion . '%', '%' . $usuario . '%');
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarResumenHistoricoUsuario($legajo) {
        $consulta = "SELECT aoperacion, count(*) total FROM vwlog_actividad WHERE ulegajo = ? GROUP BY aoperacion";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$legajo));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarResumenHoyUsuario($legajo) {
        $consulta = "SELECT aoperacion, count(*) total FROM vwlog_actividad WHERE ulegajo = ? AND CAST(afecha AS DATE) = CAST(GETDATE() AS DATE) GROUP BY aoperacion";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$legajo));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimasCreadas() {
        $consulta = "SELECT TOP(10) * FROM vwlog_actividad ORDER BY aid DESC";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
