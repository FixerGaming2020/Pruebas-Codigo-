<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorHardware {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $resultado = Hardwares::buscar($nombre, $estado);
        $this->mensaje = Hardwares::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $hardware = new Hardware($id, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $estado);
            $modificacion = $hardware->cambiarEstado();
            $this->mensaje = $hardware->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 0;
    }

    public function crear($tipo, $sigla, $nombre, $dominio, $swBase, $ambiente, $funcion, $sucursal, $marca, $modelo, $arquitectura, $core, $procesador, $mhz, $memoria, $disco, $raid, $red, $rti) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $hardware = new Hardware(NULL, $tipo, $sigla, $nombre, $dominio, $swBase, $ambiente, $funcion, $sucursal, $marca, $modelo, $arquitectura, $core, $procesador, $mhz, $memoria, $disco, $raid, $red, $rti);
            $creacion = $hardware->crear();
            $this->mensaje = $hardware->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 0;
    }

    public function consultar($nombre, $tipo, $ambiente, $dominio, $sitio) {
        $resultado = Hardwares::consultar($nombre, $tipo, $ambiente, $dominio, $sitio);
        $this->mensaje = Hardwares::getMensaje();
        return $resultado;
    }

    public function listar() {
        $resultado = Hardwares::listarUltimosCreados();
        $this->mensaje = Hardwares::getMensaje();
        return $resultado;
    }

    public function listarUltimosCreados() {
        $hardwares = new Hardwares();
        $resultado = $hardwares->listarUltimosCreados();
        $this->mensaje = $hardwares->getMensaje();
        return $resultado;
    }

    public function modificar($id, $tipo, $sigla, $nombre, $dominio, $swBase, $ambiente, $funcion, $ubicacion, $marca, $modelo, $arquitectura, $core, $procesador, $mhz, $memoria, $disco, $raid, $red, $rti) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $hardware = new Hardware($id, $tipo, $sigla, $nombre, $dominio, $swBase, $ambiente, $funcion, $ubicacion, $marca, $modelo, $arquitectura, $core, $procesador, $mhz, $memoria, $disco, $raid, $red, $rti);
            $modificacion = $hardware->modificar();
            $this->mensaje = $hardware->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

}
