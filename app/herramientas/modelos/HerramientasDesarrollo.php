<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HerramientasDesarrollo {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscar($nombre, $estado) {
        $consulta = "SELECT * FROM her_herramienta WHERE nombre LIKE ? AND estado = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', $estado));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function consultar($nombre, $version, $fabricante) {
        $consulta = "SELECT * FROM her_herramienta WHERE nombre LIKE ? AND version LIKE ? AND fabricante LIKE ? AND estado = 'Activa'";
        $datos = array('%' . $nombre . '%', '%' . $version . '%', '%' . $fabricante . '%');
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimasCreadas() {
        $consulta = "SELECT TOP(10) * FROM her_herramienta WHERE estado = 'Activa' ORDER BY id DESC";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function seleccionar($nombre) {
        $consulta = "SELECT id, nombre, version FROM her_herramienta WHERE nombre LIKE ? AND estado = 'Activa' ORDER BY nombre";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%'));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
