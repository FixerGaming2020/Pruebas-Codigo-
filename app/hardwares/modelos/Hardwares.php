<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Hardwares {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscar($nombre, $estado) {
        $consulta = "SELECT * FROM vwhar_hardware WHERE hnombre LIKE ? AND hestado = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', $estado));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function consultar($nombre, $tipo, $ambiente, $dominio, $sitio) {
        $tipo = ($tipo == "TODOS") ? "" : $tipo;
        $ambiente = ($ambiente == "TODOS") ? "" : $ambiente;
        $dominio = ($dominio == "TODOS") ? "" : $dominio;
        $consulta = "SELECT * FROM vwhar_hardware WHERE hnombre LIKE ? AND htipo LIKE ? AND hambiente LIKE ? AND hdominio LIKE ? AND snombre LIKE ? AND hestado = 'Activo'";
        $datos = array('%' . utf8_decode($nombre) . '%', '%' . utf8_decode($tipo) . '%', '%' . utf8_decode($ambiente) . '%', '%' . utf8_decode($dominio) . '%', '%' . utf8_decode($sitio) . '%');
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimosCreados() {
        $consulta = "SELECT TOP(10) * FROM vwhar_hardware WHERE hestado = 'Activo' ORDER BY hid DESC";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
