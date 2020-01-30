<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Inventarios {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function historicoAplicaciones($inventario) {
        $consulta = "SELECT * FROM vwinv_aplicacion WHERE inventario = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$inventario));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function historicoBaseDatos($inventario) {
        $consulta = "SELECT * FROM vwinv_base WHERE inventario = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$inventario));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function historicoElementosAuxiliares($inventario) {
        $consulta = "SELECT * FROM vwinv_auxiliar WHERE inventario = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$inventario));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function historicoComunicacion($inventario) {
        $consulta = "SELECT * FROM vwinv_comunicacion WHERE inventario = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$inventario));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function historicoFirewall($inventario) {
        $consulta = "SELECT * FROM vwinv_firewall WHERE inventario = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$inventario));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function historicoHardware($inventario) {
        $consulta = "SELECT * FROM vwinv_hardware WHERE inventario = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$inventario));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function historicoInstalacion($inventario) {
        $consulta = "SELECT * FROM vwinv_instalacion WHERE inventario = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$inventario));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function historicoSwitch($inventario) {
        $consulta = "SELECT * FROM vwinv_switch WHERE inventario = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$inventario));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listar($nombre) {
        $consulta = "SELECT id FROM inv_inventario WHERE id LIKE ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%'));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
