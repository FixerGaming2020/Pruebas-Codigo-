<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorAuxiliar {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $resultado = ElementosAuxiliares::buscar($nombre, $estado);
        $this->mensaje = ElementosAuxiliares::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $auxiliar = new ElementoAuxiliar($id, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $estado);
            $modificacion = $auxiliar->cambiarEstado();
            $this->mensaje = $auxiliar->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function crear($sigla, $nombre, $gerencia, $empleado, $sitio, $cantidad, $descripcion, $rti) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $auxiliar = new ElementoAuxiliar(NULL, $sigla, $nombre, $gerencia, $empleado, $sitio, $cantidad, $descripcion, $rti);
            $creacion = $auxiliar->crear();
            $this->mensaje = $auxiliar->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function consultar($nombre, $gerencia, $empleado, $sitio) {
        $resultado = ElementosAuxiliares::consultar($nombre, $gerencia, $empleado, $sitio);
        $this->mensaje = ElementosAuxiliares::getMensaje();
        return $resultado;
    }

    public function listarUltimosCreados() {
        $resultado = ElementosAuxiliares::listarUltimosCreados();
        $this->mensaje = ElementosAuxiliares::getMensaje();
        return $resultado;
    }

    public function modificar($id, $sigla, $nombre, $gerencia, $empleado, $sitio, $cantidad, $descripcion, $rti) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $auxiliar = new ElementoAuxiliar($id, $sigla, $nombre, $gerencia, $empleado, $sitio, $cantidad, $descripcion, $rti);
            $modificacion = $auxiliar->modificar();
            $this->mensaje = $auxiliar->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

}
