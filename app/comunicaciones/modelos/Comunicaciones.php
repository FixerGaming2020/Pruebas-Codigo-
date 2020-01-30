<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Comunicaciones {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscar($nombre, $estado) {
        $consulta = "SELECT * FROM vwcom_comunicacion WHERE cnombre LIKE ? AND cestado = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . utf8_decode($nombre) . '%', &$estado));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function consultar($nombre, $gerencia, $empleado, $sitio, $proveedor) {
        $consulta = "SELECT * FROM vwcom_comunicacion WHERE cnombre LIKE ? AND gnombre LIKE ? AND enombre LIKE ? AND snombre LIKE ? AND pnombre LIKE ? AND cestado = 'Activa'";
        $datos = array('%' . utf8_decode($nombre) . '%', '%' . utf8_decode($gerencia) . '%', '%' . utf8_decode($empleado) . '%', '%' . utf8_decode($sitio) . '%', '%' . utf8_decode($proveedor) . '%');
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimasCreadas() {
        $consulta = "SELECT TOP(10) * FROM vwcom_comunicacion WHERE cestado = 'Activa' ORDER BY cid DESC";
        $resultado = SQLServer::instancia()->seleccionar($consulta);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
