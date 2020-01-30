<?php

/**
 * Description of ControladorDepartamento
 *
 * @author Emanuel
 */
class ControladorDepartamento {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $resultado = Departamentos::buscar($nombre, $estado);
        $this->mensaje = Departamentos::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $departamento = new Departamento($id, NULL, NULL, $estado);
            $modificacion = $departamento->cambiarEstado();
            $this->mensaje = $departamento->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function crear($nombre, $gerencia) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $departamento = new Departamento(NULL, $nombre, $gerencia);
            $creacion = $departamento->crear();
            $this->mensaje = $departamento->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 0;
    }

    public function listarUltimosCreados() {
        $resultado = Departamentos::listarUltimosCreados();
        $this->mensaje = Departamentos::getMensaje();
        return $resultado;
    }

    public function modificar($id, $nombre, $gerencia) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $departamento = new Departamento($id, $nombre, $gerencia);
            $modificacion = $departamento->modificar();
            $this->mensaje = $departamento->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function seleccionar($nombre) {
        $resultado = Departamentos::seleccionar($nombre);
        $this->mensaje = Departamentos::getMensaje();
        return $resultado;
    }

}
