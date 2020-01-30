<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorLenguaje {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $resultado = LenguajesProgramacion::buscar($nombre, $estado);
        $this->mensaje = LenguajesProgramacion::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $lenguaje = new LenguajeProgramacion($id, NULL, NULL, NULL, $estado);
            $modificacion = $lenguaje->cambiarEstado();
            $this->mensaje = $lenguaje->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function crear($nombre, $version, $descripcion) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $lenguaje = new LenguajeProgramacion(NULL, $nombre, $version, $descripcion);
            $creacion = $lenguaje->crear();
            $this->mensaje = $lenguaje->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function consultar($nombre, $version) {
        $resultado = LenguajesProgramacion::consultar($nombre, $version);
        $this->mensaje = LenguajesProgramacion::getMensaje();
        return $resultado;
    }

    public function listarUltimosCreados() {
        $resultado = LenguajesProgramacion::listarUltimosCreados();
        $this->mensaje = LenguajesProgramacion::getMensaje();
        return $resultado;
    }

    public function modificar($id, $nombre, $version, $descripcion) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $lenguaje = new LenguajeProgramacion($id, $nombre, $version, $descripcion);
            $modificacion = $lenguaje->modificar();
            $this->mensaje = $lenguaje->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function seleccionar($nombre) {
        $resultado = LenguajesProgramacion::seleccionar($nombre);
        $this->mensaje = LenguajesProgramacion::getMensaje();
        return $resultado;
    }

}
