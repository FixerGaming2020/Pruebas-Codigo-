<?php

/**
 * Description of ControladorBase
 *
 * @author Emanuel
 */
class ControladorBase {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $motor, $collation) {
        $resultado = BasesDatos::buscar($nombre, $motor, $collation);
        $this->mensaje = BasesDatos::getMensaje();
        return $resultado;
    }

    public function consultar($nombre, $motor, $sproduccion, $stest, $sdesarrollo) {
        $resultado = BasesDatos::consultar($nombre, $motor, $sproduccion, $stest, $sdesarrollo);
        $this->mensaje = BasesDatos::getMensaje();
        return $resultado;
    }

    public function modificar($id, $test, $desarrollo, $rti) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $base = new BaseDatos($id, NULL, NULL, $test, $desarrollo, NULL, NULL, NULL, NULL, $rti);
            $modificacion = $base->modificar();
            $this->mensaje = $base->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar con la base";
        return 1;
    }

    public function listarUltimasActualizadas() {
        $resultado = BasesDatos::listarUltimasActualizadas();
        $this->mensaje = BasesDatos::getMensaje();
        return $resultado;
    }

    public function obtener($idBase) {
        $resultado = BasesDatos::obtener($idBase);
        $this->mensaje = BasesDatos::getMensaje();
        return $resultado;
    }

    public function seleccionar($nombre) {
        $resultado = BasesDatos::seleccionar($nombre);
        $this->mensaje = BasesDatos::getMensaje();
        return $resultado;
    }

}
