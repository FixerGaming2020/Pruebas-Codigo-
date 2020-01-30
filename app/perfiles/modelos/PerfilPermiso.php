<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PerfilPermiso {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function borrar($idPerfil) {
        if ($idPerfil) {
            $consulta = "DELETE FROM seg_perfil_permiso WHERE idPerfil = ?";
            $eliminacion = SQLServer::$instancia->borrar($consulta, array(&$idPerfil));
            self::$mensaje = SQLServer::instancia()->getMensaje();
            return $eliminacion;
        }
        self::$mensaje = "No se pudo hacer referencia al perfil";
        return 0;
    }

    public static function crear($idPerfil, $permisos) {
        if ($idPerfil && !empty($permisos)) {
            $registros = "";
            foreach ($permisos as $idPermiso) {
                $registros .= "({$idPerfil}, {$idPermiso}),";
            }
            $consulta = "INSERT INTO seg_perfil_permiso VALUES " . substr($registros, 0, -1);
            $creacion = SQLServer::instancia()->ejecutar($consulta);
            self::$mensaje = SQLServer::instancia()->getMensaje();
            return $creacion;
        }
        self::$mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

}
