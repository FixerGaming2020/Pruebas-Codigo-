<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorModoProcesamiento {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $resultado = ModosProcesamiento::buscar($nombre, $estado);
        $this->mensaje = ModosProcesamiento::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $modo = new ModoProcesamiento($id, NULL, $estado);
            $modificacion = $modo->cambiarEstado();
            $this->mensaje = $modo->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function crear($nombre) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $modo = new ModoProcesamiento(NULL, $nombre);
            $creacion = $modo->crear();
            $this->mensaje = $modo->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function listarUltimosCreados() {
        $resultado = ModosProcesamiento::listarUltimosCreados();
        $this->mensaje = ModosProcesamiento::getMensaje();
        return $resultado;
    }

    public function modificar($id, $nombre) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $modo = new ModoProcesamiento($id, $nombre);
            $modificacion = $modo->modificar();
            $this->mensaje = $modo->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function seleccionar($nombre) {
        $resultado = ModosProcesamiento::seleccionar($nombre);
        $this->mensaje = ModosProcesamiento::getMensaje();
        return $resultado;
    }

}
