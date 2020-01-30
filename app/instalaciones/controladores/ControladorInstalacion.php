<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorInstalacion {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $resultado = Instalaciones::buscar($nombre, $estado);
        $this->mensaje = Instalaciones::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $instalacion = new Instalacion($id, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $estado);
            $modificacion = $instalacion->cambiarEstado();
            $this->mensaje = $instalacion->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function crear($sigla, $nombre, $gerencia, $descripcion, $plataforma, $responsable, $ubicacion, $rti) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $instalacion = new Instalacion(NULL, $sigla, $nombre, $gerencia, $descripcion, $plataforma, $responsable, $ubicacion, $rti);
            $creacion = $instalacion->crear();
            $this->mensaje = $instalacion->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function consultar($nombre, $gerencia, $empleado, $sitio) {
        $resultado = Instalaciones::consultar($nombre, $gerencia, $empleado, $sitio);
        $this->mensaje = Instalaciones::getMensaje();
        return $resultado;
    }

    public function listarUltimasCreadas() {
        $resultado = Instalaciones::listarUltimasCreadas();
        $this->mensaje = Instalaciones::getMensaje();
        return $resultado;
    }

    public function modificar($id, $sigla, $nombre, $gerencia, $descripcion, $plataforma, $responsable, $ubicacion, $rti) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $instalacion = new Instalacion($id, $sigla, $nombre, $gerencia, $descripcion, $plataforma, $responsable, $ubicacion, $rti);
            $modificacion = $instalacion->modificar();
            $this->mensaje = $instalacion->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function seleccionar($nombre) {
        $resultado = Instalaciones::seleccionar($nombre);
        $this->mensaje = Instalaciones::getMensaje();
        return $resultado;
    }

}
