<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorColumna {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($base, $tabla, $nombre, $descripcion) {
        $resultado = Columnas::buscar($base, $tabla, $nombre, $descripcion);
        $this->mensaje = Columnas::getMensaje();
        return $resultado;
    }

    public function modificar($id, $descripcion) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $base = new Columna($id, NULL, NULL, NULL, NULL, NULL, $descripcion);
            $modificacion = $base->modificar();
            $this->mensaje = $base->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar con la columna";
        return 1;
    }

    public function listarPorTabla($idTabla) {
        $resultado = Columnas::listarPorTabla($idTabla);
        $this->mensaje = Columnas::getMensaje();
        return $resultado;
    }

    public function listarUltimosActualizados() {
        $resultado = Columnas::listarUltimosActualizados();
        $this->mensaje = Columnas::getMensaje();
        return $resultado;
    }

}
