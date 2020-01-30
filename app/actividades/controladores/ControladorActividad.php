<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorActividad {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($modulo, $operacion, $usuario, $fecha) {
        $resultado = Actividades::buscar($modulo, $operacion, $usuario, $fecha);
        $this->mensaje = Actividades::getMensaje();
        return $resultado;
    }

    public function listarResumenHistoricoUsuario($legajo) {
        $resultado = Actividades::listarResumenHistoricoUsuario($legajo);
        $this->mensaje = Actividades::getMensaje();
        return $resultado;
    }

    public function listarResumenHoyUsuario($legajo) {
        $resultado = Actividades::listarResumenHoyUsuario($legajo);
        $this->mensaje = Actividades::getMensaje();
        return $resultado;
    }

    public function listarUltimasCreadas() {
        $resultado = Actividades::listarUltimasCreadas();
        $this->mensaje = Actividades::getMensaje();
        return $resultado;
    }

}
