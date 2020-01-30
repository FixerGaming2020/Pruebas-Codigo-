<?php

class ControladorPermiso {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $nivel) {
        $permisos = new Permisos();
        $resultado = $permisos->buscar($nombre, $nivel);
        $this->mensaje = $permisos->getMensaje();
        return $resultado;
    }

    public function crear($titulo, $nivel, $padre, $link) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $permiso = new Permiso(NULL, $titulo, $nivel, $padre, $link);
            $creacion = $permiso->crear();
            $this->mensaje = $permiso->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function borrar($id) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $permiso = new Permiso($id);
            $eliminacion = $permiso->borrar();
            $this->mensaje = $permiso->getMensaje();
            $confirmar = ($eliminacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $eliminacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function listar() {
        $permisos = new Permisos();
        $resultado = $permisos->listar();
        $this->mensaje = $permisos->getMensaje();
        return $resultado;
    }

    public function listarUltimosCreados() {
        $permisos = new Permisos();
        $resultado = $permisos->listarUltimosCreados();
        $this->mensaje = $permisos->getMensaje();
        return $resultado;
    }

    public function modificar($id, $titulo, $nivel, $padre, $link) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $permiso = new Permiso($id, $titulo, $nivel, $padre, $link);
            $edicion = $permiso->modificar();
            $this->mensaje = $permiso->getMensaje();
            $confirmar = ($edicion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $edicion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function seleccionar($nombre, $nivel) {
        $permisos = new Permisos();
        $resultado = $permisos->selecccionar($nombre, $nivel);
        $this->mensaje = $permisos->getMensaje();
        return $resultado;
    }

}
