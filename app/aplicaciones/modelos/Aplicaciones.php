<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Aplicaciones {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscarPP($nombre, $estado) {
        $consulta = "SELECT * FROM vwapl_aplicacion WHERE anombre LIKE ? AND aestado = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', $estado));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function buscarSP($sigla, $nombre, $tipo) {
        $consulta = "SELECT * FROM vwapl_aplicacion WHERE asigla LIKE ? AND anombre LIKE ? AND atipo = ? AND aestado = 'Activa'";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $sigla . '%', '%' . $nombre . '%', utf8_decode($tipo)));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function buscarTP($sigla, $nombre) {
        $consulta = "SELECT * FROM vwapl_aplicacion WHERE asigla LIKE ? AND anombre LIKE ? AND aestado = 'Activa'";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $sigla . '%', '%' . $nombre . '%'));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function consultar($nombre, $tipo, $seguridad, $tecnologia) {
        $tipo = ($tipo == "TODOS") ? "" : $tipo;
        $seguridad = ($seguridad == "TODOS") ? "" : $seguridad;
        $tecnologia = ($tecnologia == "TODOS") ? "" : $tecnologia;
        $consulta = "SELECT * FROM vwapl_aplicacion WHERE anombre LIKE ? AND atipo LIKE ? AND aseguridad LIKE ? AND atecnologia LIKE ? AND aestado = 'Activa'";
        $datos = array('%' . $nombre . '%', '%' . $tipo . '%', '%' . $seguridad . '%', '%' . $tecnologia . '%');
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimasCreadas() {
        $consulta = "SELECT * FROM vwapl_aplicacion WHERE aestado = 'Activa' ORDER BY aid DESC";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
