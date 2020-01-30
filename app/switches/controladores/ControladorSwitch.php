<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorSwitch {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $resultado = Switches::buscar($nombre, $estado);
        $this->mensaje = Switches::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $switch = new Switchs($id, NULL, NULL, NULL, NULL, NULL, NULL, $estado);
            $modificacion = $switch->cambiarEstado();
            $this->mensaje = $switch->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function crear($nombre, $modelo, $version, $sitio, $instalacion, $rti) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $switch = new Switchs(NULL, $nombre, $modelo, $version, $sitio, $instalacion, $rti);
            $creacion = $switch->crear();
            $this->mensaje = $switch->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function consultar($nombre, $modelo, $instalacion, $sitio) {
        $resultado = Switches::consultar($nombre, $modelo, $instalacion, $sitio);
        $this->mensaje = Switches::getMensaje();
        return $resultado;
    }

    public function listarUltimosCreados() {
        $resultado = Switches::listarUltimosCreados();
        $this->mensaje = Switches::getMensaje();
        return $resultado;
    }

    public function modificar($id, $nombre, $modelo, $version, $sitio, $instalacion, $rti) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $switch = new Switchs($id, $nombre, $modelo, $version, $sitio, $instalacion, $rti);
            $modificacion = $switch->modificar();
            $this->mensaje = $switch->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

}
