<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Vistas {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscar($base, $nombre, $tipo, $descripcion) {
        $top = (!$base && (!$nombre || strlen($nombre) <= 2) && !$tipo && !$descripcion) ? "TOP(5000)" : "";
        $consulta = "SELECT {$top} * FROM vwbas_vista WHERE bnombre LIKE ? AND vnombre LIKE ? AND vdescripcion LIKE ? AND vtipoConsulta = ?";
        $datos = array('%' . $base . '%', '%' . $nombre . '%', '%' . $descripcion . '%', &$tipo);
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarPorBase($idBase) {
        $consulta = "SELECT * FROM vwbas_vista WHERE bid = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$idBase));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimasActualizadas() {
        $consulta = "SELECT TOP(10) * FROM vwbas_vista ORDER BY vfechaProceso DESC";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
