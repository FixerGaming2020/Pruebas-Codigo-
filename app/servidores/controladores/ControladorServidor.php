<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorServidor
 *
 * @author Emanuel
 */
class ControladorServidor {

    //put your code here

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $tipo, $estado) {
        $resultado = Servidores::buscar($nombre, $tipo, $estado);
        $this->mensaje = Servidores::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $servicio = new Servidor($id, NULL, NULL, NULL, NULL, $estado);
            $modificacion = $servicio->cambiarEstado();
            $this->mensaje = $servicio->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function crear($ip, $nombre, $ambiente, $tipo, $descripcion) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $servidor = new Servidor($ip, $nombre, $ambiente, $tipo, $descripcion);
            $creacion = $servidor->crear();
            $this->mensaje = $servidor->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar con el servidor";
        return 0;
    }

    public function consultar($nombre, $tipo, $ambiente) {
        $resultado = Servidores::consultar($nombre, $tipo, $ambiente);
        $this->mensaje = Servidores::getMensaje();
        return $resultado;
    }

    public function listarReporte() {
        $resultado = Servidores::listarReporte();
        $this->mensaje = Servidores::getMensaje();
        return $resultado;
    }

    public function listarUltimosCreados() {
        $resultado = Servidores::listarUltimosCreados();
        $this->mensaje = Servidores::getMensaje();
        return $resultado;
    }

    public function modificar($ipOriginal, $ip, $nombre, $ambiente, $tipo, $descripcion) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $servidor = new Servidor($ip, $nombre, $ambiente, $tipo, $descripcion);
            $modificacion = $servidor->modificar($ipOriginal);
            $this->mensaje = $servidor->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar con el servidor";
        return 0;
    }

    public function seleccionar($nombre, $ambiente, $tipo) {
        $resultado = Servidores::seleccionar($nombre, $ambiente, $tipo);
        $this->mensaje = Servidores::getMensaje();
        return $resultado;
    }

}
