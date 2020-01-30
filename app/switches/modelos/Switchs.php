<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Switchs {

    private $id;
    private $nombre;
    private $modelo;
    private $version;
    private $sitio;
    private $instalacion;
    private $rti;
    private $estado;
    private $mensaje;

    public function __construct($id = NULL, $nombre = NULL, $modelo = NULL, $version = NULL, $sitio = NULL, $instalacion = NULL, $rti = NULL, $estado = NULL) {
        $this->id = $id;
        $this->nombre = utf8_decode($nombre);
        $this->modelo = utf8_decode($modelo);
        $this->version = utf8_decode($version);
        $this->sitio = $sitio;
        $this->instalacion = $instalacion;
        $this->rti = $rti;
        $this->estado = $estado;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function getVersion() {
        return $this->version;
    }

    public function getSitio() {
        return $this->sitio;
    }

    public function getInstalacion() {
        return $this->instalacion;
    }

    public function getRti() {
        return $this->rti;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    public function setVersion($version) {
        $this->version = $version;
    }

    public function setSitio($sitio) {
        $this->sitio = $sitio;
    }

    public function setInstalacion($instalacion) {
        $this->instalacion = $instalacion;
    }

    public function setRti($rti) {
        $this->rti = $rti;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function cambiarEstado() {
        if ($this->id && $this->estado) {
            $consulta = "UPDATE swi_switch SET estado = ? WHERE id=?";
            $modificacion = SQLServer::instancia()->modificar($consulta, array(&$this->estado, &$this->id));
            $this->mensaje = SQLServer::instancia()->getMensaje();
            if ($modificacion == 2) {
                $operacion = ($this->estado == 'Activo') ? "ALTA" : "BAJA";
                $modificacion = $this->registrarActividad($operacion, $this->id);
            }
            return $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function crear() {
        if ($this->nombre && $this->modelo && $this->version && $this->sitio && $this->instalacion && $this->rti) {
            $consulta = "INSERT INTO swi_switch OUTPUT INSERTED.id VALUES (?, ?, ?, ?, ?, ?, 'Activo')";
            $datos = array(&$this->nombre, &$this->modelo, &$this->version, &$this->instalacion, &$this->sitio, &$this->rti);
            $creacion = SQLServer::instancia()->insertar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            if ($creacion == 2) {
                $this->id = SQLServer::instancia()->getUltimoId();
                $creacion = $this->registrarActividad("CREACION", $this->id);
            }
            return $creacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function modificar() {
        if ($this->nombre && $this->modelo && $this->version && $this->sitio && $this->instalacion && $this->rti) {
            $consulta = "UPDATE swi_switch SET nombre = ?, modelo = ?, version = ?, instalacion = ?, sitio = ?,  rti = ? WHERE id=?";
            $datos = array(&$this->nombre, &$this->modelo, &$this->version, &$this->instalacion, $this->sitio, &$this->rti, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return ($modificacion == 2) ? $this->registrarActividad("MODIFICACION", $this->id) : $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM swi_switch WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (gettype($fila) == "array") {
                $this->nombre = $fila['nombre'];
                $this->modelo = $fila['modelo'];
                $this->version = $fila['version'];
                $this->rti = $fila['rti'];
                $this->estado = $fila['estado'];
                $sitio = $this->obtenerSitio($fila['sitio']);
                $instalacion = $this->obtenerInstalacion($fila['instalacion']);
                return (($sitio == 2) && ($instalacion == 2)) ? 2 : 1;
            }
            $this->mensaje = "No se pudo obtener la información del switch";
            return 1;
        }
        $this->descripcion = "No se pudo hacer referencia al switch";
        return 0;
    }

    private function obtenerSitio($idSitio) {
        $sitio = new Sitio($idSitio);
        $resultado = $sitio->obtener();
        $this->sitio = ($resultado == 2) ? $sitio : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener la ubicación";
        return $resultado;
    }

    private function obtenerInstalacion($idInstalacion) {
        $instalacion = new Instalacion($idInstalacion);
        $resultado = $instalacion->obtener();
        $this->instalacion = ($resultado == 2) ? $instalacion : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener la instalación";
        return $resultado;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("swi_switch", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
