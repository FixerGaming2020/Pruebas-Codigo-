<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorServicio {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $resultado = Servicios::buscar($nombre, $estado);
        $this->mensaje = Servicios::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $servicio = new Servicio($id, NULL, NULL, NULL, $estado);
            $modificacion = $servicio->cambiarEstado();
            $this->mensaje = $servicio->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function crear($sigla, $nombre, $descripcion) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $servicio = new Servicio(NULL, $sigla, $nombre, $descripcion);
            $creacion = $servicio->crear();
            $this->mensaje = $servicio->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function listarUltimosCreados() {
        $resultado = Servicios::listarUltimosCreados();
        $this->mensaje = Servicios::getMensaje();
        return $resultado;
    }

    public function modificar($id, $sigla, $nombre, $descripcion) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $servicio = new Servicio($id, $sigla, $nombre, $descripcion);
            $modificacion = $servicio->modificar();
            $this->mensaje = $servicio->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

}
