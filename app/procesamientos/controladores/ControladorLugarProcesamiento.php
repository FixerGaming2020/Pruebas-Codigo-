<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorLugarProcesamiento {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $resultado = LugaresProcesamiento::buscar($nombre, $estado);
        $this->mensaje = LugaresProcesamiento::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $lugar = new LugarProcesamiento($id, NULL, $estado);
            $modificacion = $lugar->cambiarEstado();
            $this->mensaje = $lugar->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function crear($nombre) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $lugar = new LugarProcesamiento(NULL, $nombre);
            $creacion = $lugar->crear();
            $this->mensaje = $lugar->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function listarUltimosCreados() {
        $resultado = LugaresProcesamiento::listarUltimosCreados();
        $this->mensaje = LugaresProcesamiento::getMensaje();
        return $resultado;
    }

    public function modificar($id, $nombre) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $lugar = new LugarProcesamiento($id, $nombre);
            $modificacion = $lugar->modificar();
            $this->mensaje = $lugar->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function seleccionar($nombre) {
        $resultado = LugaresProcesamiento::seleccionar($nombre);
        $this->mensaje = LugaresProcesamiento::getMensaje();
        return $resultado;
    }

}
