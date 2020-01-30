<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ActivosHijos {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscar($nombre, $estado) {
        $consulta = "SELECT * FROM dep_activo_hijo WHERE nombre LIKE ? AND estado = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', $estado));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarActivosPadre($idPadre) {
        $consulta = "SELECT hij.* FROM dep_dependencia dep INNER JOIN dep_activo_hijo hij ON hij.id = dep.idHijo WHERE dep.idPadre = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array($idPadre));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimosCreados() {
        $consulta = "SELECT TOP(10) * FROM dep_activo_hijo WHERE estado = 'Activo' ORDER BY id DESC";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
