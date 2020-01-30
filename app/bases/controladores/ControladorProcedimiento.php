<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorProcedimiento {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($base, $nombre, $definicion, $descripcion) {
        $resultado = Procedimientos::buscar($base, $nombre, $definicion, $descripcion);
        $this->mensaje = Procedimientos::getMensaje();
        return $resultado;
    }

    public function modificar($id, $descripcion) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $procedimiento = new Procedimiento($id, NULL, NULL, NULL, NULL, NULL, $descripcion);
            $modificacion = $procedimiento->modificar();
            $this->mensaje = $procedimiento->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar con el procedimiento";
        return 1;
    }

    public function listarPorBase($idBase) {
        $resultado = Procedimientos::listarPorBase($idBase);
        $this->mensaje = Procedimientos::getMensaje();
        return $resultado;
    }

    public function listarUltimosModificados() {
        $resultado = Procedimientos::listarUltimosModificados();
        $this->mensaje = Procedimientos::getMensaje();
        return $resultado;
    }

}
