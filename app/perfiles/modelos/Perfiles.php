<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Perfiles {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $consulta = "SELECT * FROM vwseg_perfil WHERE nombre LIKE ? AND estado = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', $estado));
        $this->mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public function listarUltimosCreados() {
        $consulta = "SELECT TOP(10) * FROM vwseg_perfil WHERE estado = 'Activo' ORDER BY id DESC";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        $this->mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public function seleccionar($nombre, $estado = 'Activo') {
        $consulta = "SELECT * FROM vwseg_perfil WHERE nombre LIKE ? AND estado = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', $estado));
        $this->mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
