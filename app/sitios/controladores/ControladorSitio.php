<?php

class ControladorSitio {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $resultado = Sitios::buscar($nombre, $estado);
        $this->mensaje = Sitios::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $sitio = new Sitio($id, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $estado);
            $modificacion = $sitio->cambiarEstado();
            $this->mensaje = $sitio->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function crear($codigo, $tipo, $nombre, $provincia, $localidad, $codigoPostal, $direccion, $origen) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $sitio = new Sitio($codigo, $tipo, $nombre, $provincia, $localidad, $codigoPostal, $direccion, $origen);
            $creacion = $sitio->crear();
            $this->mensaje = $sitio->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar con el sitio";
        return 1;
    }

    public function listarReporte() {
        $resultado = Sitios::listarReporte();
        $this->mensaje = Sitios::getMensaje();
        return $resultado;
    }

    public function listarUltimosCreados() {
        $resultado = Sitios::listarUltimosCreados();
        $this->mensaje = Sitios::getMensaje();
        return $resultado;
    }

    public function modificar($id, $nombre, $tipo, $provincia, $localidad, $codigoPostal, $direccion, $origen) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $sitio = new Sitio($id, $tipo, $nombre, $provincia, $localidad, $codigoPostal, $direccion, $origen);
            $modificacion = $sitio->modificar();
            $this->mensaje = $sitio->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function seleccionar($nombre, $tipo) {
        $resultado = Sitios::seleccionar($nombre, $tipo);
        $this->mensaje = Sitios::getMensaje();
        return $resultado;
    }

}
