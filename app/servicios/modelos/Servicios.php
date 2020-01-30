<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Servicios {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscar($nombre, $estado) {
        $consulta = "SELECT * FROM srv_servicio WHERE nombre LIKE ? AND estado = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', &$estado));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarServiciosProveedor($idProveedor) {
        $consulta = "SELECT ser.* FROM pro_proveedor_servicio rel INNER JOIN srv_servicio ser ON ser.id = rel.idServicio WHERE rel.idProveedor = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$idProveedor));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimosCreados() {
        $consulta = "SELECT * FROM srv_servicio WHERE estado = 'Activo' ORDER BY id";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
