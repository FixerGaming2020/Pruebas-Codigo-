<?php

/**
 * Description of ControladorResponsable
 *
 * @author Emanuel
 */
class ControladorResponsable {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $resultado = Responsables::buscar($nombre, $estado);
        $this->mensaje = Responsables::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $responsable = new Responsable($id, NULL, NULL, NULL, NULL, $estado);
            $modificacion = $responsable->cambiarEstado();
            $this->mensaje = $responsable->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function crear($nombre, $telefono, $correo, $proveedor) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $responsable = new Responsable(NULL, $nombre, $telefono, $correo, $proveedor);
            $creacion = $responsable->crear();
            $this->mensaje = $responsable->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
    }

    public function consultar($nombre, $proveedor) {
        $resultado = Responsables::consultar($nombre, $proveedor);
        $this->mensaje = Responsables::getMensaje();
        return $resultado;
    }

    public function listarUltimosCreados() {
        $resultado = Responsables::listarUltimosCreados();
        $this->mensaje = Responsables::getMensaje();
        return $resultado;
    }

    public function modificar($id, $nombre, $telefono, $correo, $proveedor) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $responsable = new Responsable($id, $nombre, $telefono, $correo, $proveedor);
            $modificacion = $responsable->modificar();
            $this->mensaje = $responsable->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
    }

}
