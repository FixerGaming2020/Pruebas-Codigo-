<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorHerramientaDesarrollo {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $resultado = HerramientasDesarrollo::buscar($nombre, $estado);
        $this->mensaje = HerramientasDesarrollo::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $herramienta = new HerramientaDesarrollo($id, NULL, NULL, NULL, NULL, $estado);
            $modificacion = $herramienta->cambiarEstado();
            $this->mensaje = $herramienta->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function consultar($nombre, $version, $fabricante) {
        $resultado = HerramientasDesarrollo::consultar($nombre, $version, $fabricante);
        $this->mensaje = HerramientasDesarrollo::getMensaje();
        return $resultado;
    }

    public function crear($nombre, $version, $fabricante, $descripcion) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $herramienta = new HerramientaDesarrollo(NULL, $nombre, $version, $fabricante, $descripcion);
            $creacion = $herramienta->crear();
            $this->mensaje = $herramienta->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function listarUltimasCreadas() {
        $resultado = HerramientasDesarrollo::listarUltimasCreadas();
        $this->mensaje = HerramientasDesarrollo::getMensaje();
        return $resultado;
    }

    public function modificar($id, $nombre, $version, $fabricante, $descripcion) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $herramienta = new HerramientaDesarrollo($id, $nombre, $version, $fabricante, $descripcion);
            $modificacion = $herramienta->modificar();
            $this->mensaje = $herramienta->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function seleccionar($nombre) {
        $resultado = HerramientasDesarrollo::seleccionar($nombre);
        $this->mensaje = HerramientasDesarrollo::getMensaje();
        return $resultado;
    }

}
