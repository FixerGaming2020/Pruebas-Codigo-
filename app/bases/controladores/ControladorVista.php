<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorVista {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($base, $nombre, $tipo, $descripcion) {
        $resultado = Vistas::buscar($base, $nombre, $tipo, $descripcion);
        $this->mensaje = Vistas::getMensaje();
        return $resultado;
    }

    public function modificar($id, $consulta, $descripcion) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $vista = new Vista($id, NULL, NULL, $consulta, $descripcion);
            $modificacion = $vista->modificar();
            $this->mensaje = $vista->getMensaje();
            $confirmar = ($modificacion == 2) ? true : false;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar con la vista";
        return 1;
    }

    public function listarPorBase($idBase) {
        $resultado = Vistas::listarPorBase($idBase);
        $this->mensaje = Vistas::getMensaje();
        return $resultado;
    }

    public function listarUltimasActualizadas() {
        $resultado = Vistas::listarUltimasActualizadas();
        $this->mensaje = Vistas::getMensaje();
        return $resultado;
    }

}
