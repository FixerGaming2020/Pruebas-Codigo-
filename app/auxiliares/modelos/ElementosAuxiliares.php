<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ElementosAuxiliares {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscar($nombre, $estado) {
        $consulta = "SELECT * FROM vwaux_auxiliar WHERE anombre LIKE ? AND aestado = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', &$estado));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function consultar($nombre, $gerencia, $empleado, $sitio) {
        $consulta = "SELECT * FROM vwaux_auxiliar WHERE anombre LIKE ? AND gnombre LIKE ? AND enombre LIKE ? AND snombre LIKE ? AND aestado = 'Activo'";
        $datos = array('%' . $nombre . '%', '%' . $gerencia . '%', '%' . $empleado . '%', '%' . $sitio . '%');
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimosCreados() {
        $consulta = "SELECT TOP(10) * FROM vwaux_auxiliar WHERE aestado = 'Activo' ORDER BY aid DESC";
        $resultado = SQLServer::instancia()->seleccionar($consulta);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
