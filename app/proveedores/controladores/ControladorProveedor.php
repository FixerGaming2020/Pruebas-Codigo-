<?php

/**
 * Description of ControladorProveedor
 *
 * @author Emanuel
 */
class ControladorProveedor {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $resultado = Proveedores::buscar($nombre, $estado);
        $this->mensaje = Proveedores::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $proveedor = new Proveedor($id, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $estado);
            $modificacion = $proveedor->cambiarEstado();
            $this->mensaje = $proveedor->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function crear($nombre, $telefono, $correo, $provincia, $localidad, $direccion, $tipo, $servicios) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $proveedor = new Proveedor(NULL, $nombre, $telefono, $correo, $provincia, $localidad, $direccion, $tipo, $servicios);
            $creacion = $proveedor->crear();
            $this->mensaje = $proveedor->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
    }

    public function consultar($nombre, $provincia) {
        $resultado = Proveedores::consultar($nombre, $provincia);
        $this->mensaje = Proveedores::getMensaje();
        return $resultado;
    }

    public function listar() {
        $proveedores = new Proveedores();
        $resultado = $proveedores->listar();
        $this->mensaje = $proveedores->getMensaje();
        return $resultado;
    }

    public function listarUltimosCreados() {
        $resultado = Proveedores::listarUltimosCreados();
        $this->mensaje = Proveedores::getMensaje();
        return $resultado;
    }

    public function modificar($id, $nombre, $telefono, $correo, $provincia, $localidad, $direccion, $tipo, $servicios) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $proveedor = new Proveedor($id, $nombre, $telefono, $correo, $provincia, $localidad, $direccion, $tipo, $servicios);
            $modificacion = $proveedor->modificar();
            $this->mensaje = $proveedor->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function seleccionar($nombre) {
        $resultado = Proveedores::seleccionar($nombre);
        $this->mensaje = Proveedores::getMensaje();
        return $resultado;
    }

}
