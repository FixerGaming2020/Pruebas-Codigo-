<?php

/**
 * Description of ControladorGerencia
 *
 * @author Emanuel
 */
class ControladorGerencia {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $resultado = Gerencias::buscar($nombre, $estado);
        $this->mensaje = Gerencias::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $gerencia = new Gerencia($id, NULL, NULL, $estado);
            $modificacion = $gerencia->cambiarEstado();
            $this->mensaje = $gerencia->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function crear($nombre, $jefe) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $gerencia = new Gerencia(NULL, $nombre, $jefe);
            $creacion = $gerencia->crear();
            $this->mensaje = $gerencia->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 0;
    }

    public function listarReporte() {
        $resultado = Gerencias::listarReporte();
        $this->mensaje = Gerencias::getMensaje();
        return $resultado;
    }

    public function listarUltimasCreadas() {
        $resultado = Gerencias::listarUltimasCreadas();
        $this->mensaje = Gerencias::getMensaje();
        return $resultado;
    }

    public function modificar($id, $nombre, $jefe) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $gerencia = new Gerencia($id, $nombre, $jefe);
            $modificacion = $gerencia->modificar();
            $this->mensaje = $gerencia->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function seleccionar($nombre) {
        $resultado = Gerencias::seleccionar($nombre);
        $this->mensaje = Gerencias::getMensaje();
        return $resultado;
    }

}
