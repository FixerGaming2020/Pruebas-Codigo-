<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorInventario {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function historicoAplicacion($inventario) {
        $resultado = Inventarios::historicoAplicaciones($inventario);
        $this->mensaje = Inventarios::getMensaje();
        return $resultado;
    }

    public function historicoBaseDatos($inventario) {
        $resultado = Inventarios::historicoBaseDatos($inventario);
        $this->mensaje = Inventarios::getMensaje();
        return $resultado;
    }

    public function historicoComunicacion($inventario) {
        $resultado = Inventarios::historicoComunicacion($inventario);
        $this->mensaje = Inventarios::getMensaje();
        return $resultado;
    }

    public function historicoElementoAuxiliar($inventario) {
        $resultado = Inventarios::historicoElementosAuxiliares($inventario);
        $this->mensaje = Inventarios::getMensaje();
        return $resultado;
    }

    public function historicoFirewall($inventario) {
        $resultado = Inventarios::historicoFirewall($inventario);
        $this->mensaje = Inventarios::getMensaje();
        return $resultado;
    }

    public function historicoHardware($inventario) {
        $resultado = Inventarios::historicoHardware($inventario);
        $this->mensaje = Inventarios::getMensaje();
        return $resultado;
    }

    public function historicoInstalacion($inventario) {
        $resultado = Inventarios::historicoInstalacion($inventario);
        $this->mensaje = Inventarios::getMensaje();
        return $resultado;
    }

    public function historicoSwitch($inventario) {
        $resultado = Inventarios::historicoSwitch($inventario);
        $this->mensaje = Inventarios::getMensaje();
        return $resultado;
    }

    public function seleccionar($nombre) {
        $resultado = Inventarios::listar($nombre);
        $this->mensaje = Inventarios::getMensaje();
        return $resultado;
    }

}
