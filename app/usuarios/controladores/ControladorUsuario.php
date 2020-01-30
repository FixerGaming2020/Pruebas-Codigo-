<?php

/**
 * Description of ControladorUsuario
 *
 * @author Emanuel
 */
class ControladorUsuario {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $usuarios = new Usuarios();
        $resultado = $usuarios->buscar($nombre, $estado);
        $this->mensaje = $usuarios->getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $usuario = new Usuario($id, NULL, $estado);
            $modificacion = $usuario->cambiarEstado();
            $this->mensaje = $usuario->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function crear($legajo, $nombre, $perfil) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $usuario = new Usuario($legajo, $nombre, NULL, $perfil);
            $creacion = $usuario->crear();
            $this->mensaje = $usuario->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function listarUltimos() {
        $usuarios = new Usuarios();
        $resultado = $usuarios->listarUltimos();
        $this->mensaje = $usuarios->getMensaje();
        return $resultado;
    }

    public function modificar($legajoOriginal, $legajo, $nombre, $perfil) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $usuario = new Usuario($legajo, $nombre, NULL, $perfil);
            $modificacion = $usuario->modificar($legajoOriginal);
            $this->mensaje = $usuario->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

}
