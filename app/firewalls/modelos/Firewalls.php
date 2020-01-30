<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Firewalls {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscar($nombre, $estado) {
        $consulta = "SELECT * FROM vwfir_firewall WHERE fnombre LIKE ? AND festado = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', $estado));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function consultar($nombre, $marca, $ip, $sitio) {
        $consulta = "SELECT * FROM vwfir_firewall WHERE fnombre LIKE ? AND fmarca LIKE ? AND fip LIKE ? AND snombre LIKE ? AND festado = 'Activo'";
        $datos = array('%' . $nombre . '%', '%' . $marca . '%', '%' . $ip . '%', '%' . $sitio . '%');
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimosCreados() {
        $consulta = "SELECT TOP(10) * FROM vwfir_firewall WHERE festado = 'Activo' ORDER BY fid DESC";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
