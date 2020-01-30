<?php

/**
 * Description of ProcedimientosAlmacenados
 *
 * @author Emanuel
 */
class Procedimientos {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscar($base, $nombre, $definicion, $descripcion) {
        $top = (!$base && (!$nombre || strlen($nombre) <= 2) && !$definicion && !$descripcion) ? "TOP(5000)" : "";
        $consulta = "SELECT {$top} * FROM vwbas_procedimiento WHERE bnombre LIKE ? AND pnombre LIKE ? AND prutina LIKE ? AND pdescripcion LIKE ?";
        $datos = array('%' . $base . '%', '%' . $nombre . '%', '%' . $definicion . '%', '%' . $descripcion . '%');
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarPorBase($idBase) {
        $consulta = "SELECT * FROM vwbas_procedimiento WHERE bid = ? ORDER BY pnombre";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$idBase));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimosModificados() {
        $consulta = "SELECT TOP(10) * FROM vwbas_procedimiento ORDER BY pfechaEdicion DESC";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
