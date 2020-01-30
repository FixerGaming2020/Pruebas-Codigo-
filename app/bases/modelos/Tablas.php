<?php

class Tablas {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscar($base, $nombre, $descripcion) {
        $top = (!$base && (!$nombre || strlen($nombre) <= 2) && !$descripcion) ? "TOP(5000)" : "";
        $consulta = "SELECT {$top} * FROM vwbas_tabla WHERE bnombre LIKE ? AND tnombre LIKE ? AND tdescripcion LIKE ?";
        $datos = array('%' . $base . '%', '%' . $nombre . '%', '%' . $descripcion . '%');
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimasModificadas() {
        $consulta = "SELECT TOP(10) * FROM vwbas_tabla ORDER BY tfechaEdicion DESC";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarPorBase($idBase) {
        $consulta = "SELECT * FROM vwbas_tabla WHERE bid = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$idBase));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function seleccionar($nombre) {
        $consulta = "SELECT * FROM vwbas_tabla WHERE tnombre LIKE ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%'));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
