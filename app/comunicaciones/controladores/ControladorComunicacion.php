<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorComunicacion {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $resultado = Comunicaciones::buscar($nombre, $estado);
        $this->mensaje = Comunicaciones::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $comunicacion = new Comunicacion($id, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $estado);
            $modificacion = $comunicacion->cambiarEstado();
            $this->mensaje = $comunicacion->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function crear($sigla, $nombre, $cantidad, $gerencia, $delegado, $ubicacion, $proveedor, $rti, $descripcion) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $comunicacion = new Comunicacion(NULL, $sigla, $nombre, $cantidad, $gerencia, $delegado, $ubicacion, $proveedor, $rti, $descripcion);
            $creacion = $comunicacion->crear();
            $this->mensaje = $comunicacion->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function consultar($nombre, $gerencia, $empleado, $sitio, $proveedor) {
        $resultado = Comunicaciones::consultar($nombre, $gerencia, $empleado, $sitio, $proveedor);
        $this->mensaje = Comunicaciones::getMensaje();
        return $resultado;
    }

    public function listarUltimasCreadas() {
        $resultado = Comunicaciones::listarUltimasCreadas();
        $this->mensaje = Comunicaciones::getMensaje();
        return $resultado;
    }

    public function modificar($id, $sigla, $nombre, $cantidad, $gerencia, $delegado, $ubicacion, $proveedor, $rti, $descripcion) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $comunicacion = new Comunicacion($id, $sigla, $nombre, $cantidad, $gerencia, $delegado, $ubicacion, $proveedor, $rti, $descripcion);
            $modificacion = $comunicacion->modificar();
            $this->mensaje = $comunicacion->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

}
