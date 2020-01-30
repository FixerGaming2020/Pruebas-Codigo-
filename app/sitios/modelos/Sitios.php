<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Sitios {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscar($nombre, $estado) {
        $consulta = "SELECT * FROM sit_sitio WHERE nombre LIKE ? AND estado = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', &$estado));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarReporte() {
        $consulta = "SELECT snombre, stipo, comunicaciones, firewalls, hardwares, instalaciones, switchs FROM vwsit_sitio WHERE sestado = 'Activo'";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimosCreados() {
        $consulta = "SELECT TOP(10) * FROM sit_sitio WHERE estado = 'Activo' ORDER BY id";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function seleccionar($nombre, $tipo) {
        $consulta = "SELECT id, nombre FROM sit_sitio WHERE nombre LIKE ? AND estado = 'Activo' ";
        $consulta .= ($tipo = 'TODOS') ? "" : " AND tipo = ?";
        $datos = ($tipo = 'TODOS') ? array('%' . $nombre . '%') : array('%' . $nombre . '%', &$tipo);
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
