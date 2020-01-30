<?php

/**
 * Description of ControladorPerfil
 *
 * @author Emanuel
 */
class ControladorPerfil {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $perfiles = new Perfiles();
        $resultado = $perfiles->buscar($nombre, $estado);
        $this->mensaje = $perfiles->getMensaje();
        return $resultado;
    }

    public function crear($nombre, $descripcion, $permisos) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $perfil = new Perfil(NULL, $nombre, $descripcion, NULL, $permisos);
            $creacion = $perfil->crear();
            $this->mensaje = $perfil->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $perfil = new Perfil($id, NULL, NULL, $estado);
            $modificacion = $perfil->cambiarEstado();
            $this->mensaje = $perfil->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function listarUltimosCreados() {
        $perfiles = new Perfiles();
        $resultado = $perfiles->listarUltimosCreados();
        $this->mensaje = $perfiles->getMensaje();
        return $resultado;
    }

    public function modificar($id, $nombre, $descripcion, $permisos) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $perfil = new Perfil($id, $nombre, $descripcion, NULL, $permisos);
            $modificacion = $perfil->modificar();
            $this->mensaje = $perfil->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function seleccionar($nombre, $estado) {
        $perfiles = new Perfiles();
        $resultado = $perfiles->seleccionar($nombre, $estado);
        $this->mensaje = $perfiles->getMensaje();
        return $resultado;
    }

}
