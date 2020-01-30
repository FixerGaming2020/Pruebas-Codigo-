<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Switches {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscar($nombre, $estado) {
        $consulta = "SELECT * FROM vwswi_switch WHERE snombre LIKE ? AND sestado = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', &$estado));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function consultar($nombre, $modelo, $instalacion, $sitio) {
        $consulta = "SELECT * FROM vwswi_switch WHERE snombre LIKE ? AND smodelo LIKE ? AND inombre LIKE ? AND unombre LIKE ? AND sestado = 'Activo'";
        $datos = array('%' . $nombre . '%', '%' . $modelo . '%', '%' . $instalacion . '%', '%' . $sitio . '%');
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimosCreados() {
        $consulta = "SELECT TOP(10) * FROM vwswi_switch WHERE sestado = 'Activo' ORDER BY sid DESC";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
