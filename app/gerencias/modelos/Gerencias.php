<?php

/**
 * Description of Gerencias
 *
 * @author Emanuel
 */
class Gerencias {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscar($nombre, $estado) {
        $consulta = "SELECT * FROM vwger_gerencia WHERE gnombre LIKE ? AND gestado = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', &$estado));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimasCreadas() {
        $consulta = "SELECT TOP(10) * FROM vwger_gerencia WHERE gestado = 'Activa' ORDER BY gid DESC";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarReporte() {
        $consulta = "SELECT gnombre, aplicaciones, auxiliares, comunicaciones, departamentos, instalaciones FROM vwger_gerencia WHERE gestado = 'Activa'";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function seleccionar($nombre) {
        $consulta = "SELECT * FROM vwger_gerencia WHERE gnombre LIKE ? AND gestado = 'Activa'";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%'));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
