<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorPlataformaSO {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $resultado = PlataformasSO::buscar($nombre, $estado);
        $this->mensaje = PlataformasSO::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $plataforma = new PlataformaSO($id, NULL, $estado);
            $modificacion = $plataforma->cambiarEstado();
            $this->mensaje = $plataforma->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function crear($nombre) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $plataforma = new PlataformaSO(NULL, $nombre);
            $creacion = $plataforma->crear();
            $this->mensaje = $plataforma->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function listarUltimasCreadas() {
        $resultado = PlataformasSO::listarUltimasCreadas();
        $this->mensaje = PlataformasSO::getMensaje();
        return $resultado;
    }

    public function modificar($id, $nombre) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $plataforma = new PlataformaSO($id, $nombre);
            $modificacion = $plataforma->modificar();
            $this->mensaje = $plataforma->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function seleccionar($nombre) {
        $resultado = PlataformasSO::seleccionar($nombre);
        $this->mensaje = PlataformasSO::getMensaje();
        return $resultado;
    }

}
