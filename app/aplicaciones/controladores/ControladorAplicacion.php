<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorAplicacion {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscarPP($nombre, $estado) {
        $resultado = Aplicaciones::buscarPP($nombre, $estado);
        $this->mensaje = Aplicaciones::getMensaje();
        return $resultado;
    }

    public function buscarSP($sigla, $nombre, $tipo) {
        $resultado = Aplicaciones::buscarSP($sigla, $nombre, $tipo);
        $this->mensaje = Aplicaciones::getMensaje();
        return $resultado;
    }

    public function buscarTP($sigla, $nombre) {
        $resultado = Aplicaciones::buscarTP($sigla, $nombre);
        $this->mensaje = Aplicaciones::getMensaje();
        return $resultado;
    }

    public function consultar($nombre, $tipo, $seguridad, $tecnologia) {
        $resultado = Aplicaciones::consultar($nombre, $tipo, $seguridad, $tecnologia);
        $this->mensaje = Aplicaciones::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $aplicacion = new Aplicacion($id);
            $aplicacion->setEstado($estado);
            $modificacion = $aplicacion->cambiarEstado();
            $this->mensaje = $aplicacion->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 0;
    }

    public function crear($sigla, $nombre, $tipo, $seguridad, $tecnologia, $proveedor, $lenguaje, $herramienta, $base, $modo, $lugar, $plataforma, $empleado, $sDesarrollo, $pDesarrollo, $rti, $descripcion) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $aplicacion = new Aplicacion(NULL, $sigla, $nombre, $tipo, $seguridad, $tecnologia, $proveedor, $lenguaje, $herramienta, $base, $modo, $lugar, $plataforma, NULL, $empleado, NULL, NULL, $sDesarrollo, NULL, NULL, $pDesarrollo, NULL, NULL, NULL, NULL, $rti, $descripcion);
            $creacion = $aplicacion->crear();
            $this->mensaje = $aplicacion->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function modificarPP($id, $sigla, $nombre, $tipo, $seguridad, $tecnologia, $proveedor, $lenguaje, $herramienta, $base, $modo, $lugar, $plataforma, $empleado, $sDesarrollo, $pDesarrollo, $rti, $descripcion) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $aplicacion = new Aplicacion($id, $sigla, $nombre, $tipo, $seguridad, $tecnologia, $proveedor, $lenguaje, $herramienta, $base, $modo, $lugar, $plataforma, NULL, $empleado, NULL, NULL, $sDesarrollo, NULL, NULL, $pDesarrollo, NULL, NULL, NULL, NULL, $rti, $descripcion);
            $modificacion = $aplicacion->modificarPP();
            $this->mensaje = $aplicacion->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function modificarSP($id, $nombre, $sproduccion, $pproduccion, $stest, $ptest) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $aplicacion = new Aplicacion($id, NULL, $nombre, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $sproduccion, $stest, NULL, $pproduccion, $ptest);
            $modificacion = $aplicacion->modificarSP();
            $this->mensaje = $aplicacion->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function modificarTP($id, $nombre, $confidencialidad, $integridad, $disponibilidad, $criticidad) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $aplicacion = new Aplicacion($id, NULL, $nombre, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $confidencialidad, $integridad, $disponibilidad, $criticidad);
            $modificacion = $aplicacion->modificarTP();
            $this->mensaje = $aplicacion->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function listarUltimasCreadas() {
        $resultado = Aplicaciones::listarUltimasCreadas();
        $this->mensaje = Aplicaciones::getMensaje();
        return $resultado;
    }

}
