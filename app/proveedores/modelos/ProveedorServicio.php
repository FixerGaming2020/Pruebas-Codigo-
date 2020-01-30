<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ProveedorServicio {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function borrar($idProveedor) {
        if ($idProveedor) {
            $consulta = "DELETE FROM pro_proveedor_servicio WHERE idProveedor = ?";
            $eliminacion = SQLServer::$instancia->borrar($consulta, array(&$idProveedor));
            self::$mensaje = SQLServer::instancia()->getMensaje();
            return $eliminacion;
        }
        self::$mensaje = "No se pudo hacer referencia al proveedor";
        return 0;
    }

    public static function crear($idProveedor, $servicios) {
        if ($idProveedor && !empty($servicios)) {
            $registros = "";
            foreach ($servicios as $idServicio) {
                $registros .= "({$idProveedor}, {$idServicio}),";
            }
            $consulta = "INSERT INTO pro_proveedor_servicio VALUES " . substr($registros, 0, -1);
            $creacion = SQLServer::instancia()->ejecutar($consulta);
            self::$mensaje = SQLServer::instancia()->getMensaje();
            return $creacion;
        }
        self::$mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

}
