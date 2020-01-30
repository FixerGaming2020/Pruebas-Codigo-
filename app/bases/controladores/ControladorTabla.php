<?php

class ControladorTabla {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($base, $nombre, $descripcion) {
        $resultado = Tablas::buscar($base, $nombre, $descripcion);
        $this->mensaje = Tablas::getMensaje();
        return $resultado;
    }

    public function modificar($id, $descripcion) {
        $tabla = new Tabla($id, NULL, NULL, NULL, $descripcion);
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $modificacion = $tabla->modificar();
            $this->mensaje = $tabla->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar con la tabla";
        return 1;
    }

    public function listar($nombre) {
        $tablas = new Tablas();
        $resultado = $tablas->listar($nombre);
        $this->mensaje = $tablas->getMensaje();
        return $resultado;
    }

    public function listarUltimasModificadas() {
        $resultado = Tablas::listarUltimasModificadas();
        $this->mensaje = Tablas::getMensaje();
        return $resultado;
    }

    public function listarPorBase($idBase) {
        $tablas = new Tablas();
        $resultado = $tablas->listarPorBase($idBase);
        $this->mensaje = $tablas->getMensaje();
        return $resultado;
    }

}
