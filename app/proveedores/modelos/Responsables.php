<?php

class Responsables {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscar($nombre, $estado) {
        $consulta = "SELECT * FROM vwpro_responsable WHERE rnombre LIKE ? AND restado = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', &$estado));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function consultar($nombre, $proveedor) {
        $consulta = "SELECT * FROM vwpro_responsable WHERE rnombre LIKE ? AND pnombre LIKE ? AND restado = 'Activo'";
        $datos = array('%' . $nombre . '%', '%' . $proveedor . '%');
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimosCreados() {
        $consulta = "SELECT TOP(10) * FROM vwpro_responsable WHERE restado = 'Activo' ORDER BY rid DESC";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
