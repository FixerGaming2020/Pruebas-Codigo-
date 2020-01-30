<?php

class BasesDatos {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscar($nombre, $motor, $collation) {
        $top = (!$nombre && !$motor && !$collation) ? "TOP(400)" : "";
        $consulta = "SELECT {$top} * FROM vwbas_base WHERE bnombre LIKE ? AND bmotor LIKE ? AND bcollation LIKE ?";
        $datos = array('%' . $nombre . '%', '%' . $motor . '%', '%' . $collation . '%');
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function consultar($nombre, $motor, $sproduccion, $stest, $sdesarrollo) {
        $servidores = ($sproduccion) ? " AND pnombre LIKE ? " : "";
        $servidores .= ($stest) ? " AND tnombre LIKE ? " : "";
        $servidores .= ($sdesarrollo) ? " AND dnombre LIKE ? " : "";
        $consulta = "SELECT * FROM vwbas_base WHERE bnombre LIKE ? AND bmotor LIKE ? {$servidores} AND bestado = 'Activa'";
        $datos = array('%' . $nombre . '%', '%' . $motor . '%');
        (!$sproduccion) ?: $datos[] = '%' . $sproduccion . '%';
        (!$stest) ?: $datos[] = '%' . $stest . '%';
        (!$sdesarrollo) ?: $datos[] = '%' . $sdesarrollo . '%';

        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimasActualizadas() {
        $consulta = "SELECT TOP(10) * FROM vwbas_base WHERE bestado = 'Activa' ORDER BY bfechaProceso DESC";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function obtener($idBase) {
        $consulta = "SELECT * FROM vwbas_base WHERE bid = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$idBase));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function seleccionar($nombre) {
        $consulta = "SELECT bid, bnombre FROM vwbas_base WHERE bnombre LIKE ? ORDER BY bnombre";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%'));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
