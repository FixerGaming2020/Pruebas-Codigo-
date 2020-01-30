<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Instalaciones {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscar($nombre, $estado) {
        $consulta = "SELECT * FROM vwins_instalacion WHERE inombre LIKE ? AND iestado = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', &$estado));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function consultar($nombre, $gerencia, $empleado, $sitio) {
        $consulta = "SELECT * FROM vwins_instalacion WHERE inombre LIKE ? AND gnombre LIKE ? AND enombre LIKE ? AND snombre LIKE ? AND iestado = 'Activa'";
        $datos = array('%' . utf8_decode($nombre) . '%', '%' . utf8_decode($gerencia) . '%', '%' . utf8_decode($empleado) . '%', '%' . utf8_decode($sitio) . '%');
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimasCreadas() {
        $consulta = "SELECT TOP(10) * FROM vwins_instalacion WHERE iestado = 'Activa' ORDER BY iid DESC";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function seleccionar($nombre) {
        $consulta = "SELECT iid, inombre FROM vwins_instalacion WHERE inombre LIKE ? AND iestado = 'Activa'";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%'));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
