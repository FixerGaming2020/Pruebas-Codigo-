<?php

/**
 * Description of campos
 *
 * @author Emanuel
 */
class Columnas {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscar($base, $tabla, $nombre, $descripcion) {
        $top = (!$base && !$tabla && (!$nombre || strlen($nombre) <= 2) && !$descripcion) ? "TOP(5000)" : "";
        $consulta = "SELECT {$top} * FROM vwbas_columna WHERE bnombre LIKE ? AND tnombre LIKE ? AND cnombre LIKE ? AND cdescripcion LIKE ?";
        $datos = array('%' . $base . '%', '%' . $tabla . '%', '%' . $nombre . '%', '%' . $descripcion . '%');
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarPorTabla($idTabla) {
        $consulta = "SELECT * FROM vwbas_columna WHERE tid = ? ORDER BY cnombre";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$idTabla));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimosActualizados() {
        $consulta = "SELECT TOP(10) * FROM vwbas_columna ORDER BY cid DESC";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
