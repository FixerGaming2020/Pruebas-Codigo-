<?php

/**
 * Description of ControladorPersona
 *
 * @author Emanuel
 */
class ControladorEmpleado {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $resultado = Empleados::buscar($nombre, $estado);
        $this->mensaje = Empleados::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $persona = new Empleado($id, NULL, NULL, $estado);
            $modificacion = $persona->cambiarEstado();
            $this->mensaje = $persona->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function crear($legajo, $nombre, $departamento) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $persona = new Empleado($legajo, $nombre, $departamento);
            $creacion = $persona->crear();
            $this->mensaje = $persona->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 0;
    }

    public function listarUltimosCreados() {
        $resultado = Empleados::listarUltimosCreados();
        $this->mensaje = Empleados::getMensaje();
        return $resultado;
    }

    public function modificar($id, $nombre, $departamento, $legajo) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $persona = new Empleado($id, $nombre, $departamento);
            $modificacion = $persona->modificar($legajo);
            $this->mensaje = $persona->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function seleccionar($nombre) {
        $resultado = Empleados::seleccionar($nombre);
        $this->mensaje = Empleados::getMensaje();
        return $resultado;
    }

    public function seleccionarJefe($nombre) {
        $resultado = Empleados::seleccionarJefe($nombre);
        $this->mensaje = Empleados::getMensaje();
        return $resultado;
    }

}
