<?php

/**
 * Description of Servidores
 *
 * @author Emanuel
 */
class Servidores {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscar($nombre, $tipo, $estado) {
        $consulta = "SELECT * FROM ser_servidor WHERE nombre LIKE ? AND tipo = ? AND estado = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', &$tipo, &$estado));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function consultar($nombre, $tipo, $ambiente) {
        $tipo = ($tipo == "TODOS") ? "" : $tipo;
        $ambiente = ($ambiente == "TODOS") ? "" : $ambiente;
        $consulta = "SELECT * FROM ser_servidor WHERE nombre LIKE ? AND ambiente LIKE ? AND tipo LIKE ?";
        $datos = array('%' . $nombre . '%', '%' . $ambiente . '%', '%' . $tipo . '%');
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarReporte() {
        $consulta = "SELECT id, nombre, ambiente, bases, jobs, aplicaciones FROM vwser_servidor WHERE estado = 'Activo' ORDER BY id";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimosCreados() {
        $consulta = "SELECT TOP(10) * FROM ser_servidor WHERE estado = 'Activo' ORDER BY id";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function seleccionar($nombre, $ambiente, $tipo) {
        $consulta = "SELECT id, nombre FROM ser_servidor WHERE nombre LIKE ? AND ambiente LIKE ? AND tipo = ? OR tipo = 'Ambas'";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', &$ambiente, &$tipo));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
