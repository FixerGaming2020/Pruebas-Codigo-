<?php

/**
 * Description of Usuarios
 *
 * @author 07489
 */
class Usuarios {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $consulta = "SELECT * FROM vwseg_usuario WHERE usuNombre LIKE ? AND usuEstado = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', $estado));
        $this->mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public function seleccionar() {
        
    }

    public function listarUltimos() {
        $consulta = "SELECT TOP(10) * FROM vwseg_usuario WHERE usuEstado = 'Activo'";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        $this->mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
