<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HerramientaDesarrollo {

    private $id;
    private $nombre;
    private $version;
    private $fabricante;
    private $descripcion;
    private $estado;
    private $mensaje;

    public function __construct($id = NULL, $nombre = NULL, $version = NULL, $fabricante = NULL, $descripcion = NULL, $estado = NULL) {
        $this->id = $id;
        $this->nombre = utf8_decode($nombre);
        $this->version = utf8_decode($version);
        $this->fabricante = utf8_decode($fabricante);
        $this->descripcion = utf8_decode($descripcion);
        $this->estado = $estado;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return utf8_encode($this->nombre);
    }

    public function getVersion() {
        return utf8_encode($this->version);
    }

    public function getFabricante() {
        return utf8_encode($this->fabricante);
    }

    public function getDescripcion() {
        return utf8_encode($this->descripcion);
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
        $this->nombre = utf8_decode($nombre);
    }

    public function setVersion($version) {
        $this->version = utf8_decode($version);
    }

    public function setFabricante($fabricante) {
        $this->fabricante = utf8_decode($fabricante);
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = utf8_decode($descripcion);
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function cambiarEstado() {
        if ($this->id && $this->estado) {
            $consulta = "UPDATE her_herramienta SET estado = ? WHERE id = ?";
            $modificacion = SQLServer::instancia()->modificar($consulta, array(&$this->estado, &$this->id));
            $this->mensaje = SQLServer::instancia()->getMensaje();
            if ($modificacion == 2) {
                $operacion = ($this->estado == 'Activa') ? "ALTA" : "BAJA";
                $modificacion = $this->registrarActividad($operacion, $this->id);
            }
            return $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function crear() {
        if ($this->nombre && $this->version && $this->fabricante && $this->descripcion) {
            $consulta = "INSERT INTO her_herramienta OUTPUT INSERTED.id VALUES (?, ?, ?, ?, 'Activa')";
            $datos = array(&$this->nombre, &$this->version, &$this->fabricante, &$this->descripcion);
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
        if ($this->id && $this->nombre && $this->version && $this->fabricante && $this->descripcion) {
            $consulta = "UPDATE her_herramienta SET nombre=?, version=?, fabricante=?, descripcion=? WHERE id=?";
            $datos = array(&$this->nombre, &$this->version, &$this->fabricante, &$this->descripcion, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return ($modificacion == 2) ? $this->registrarActividad("MODIFICACION", $this->id) : $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM her_herramienta WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (gettype($fila) == "array") {
                $this->nombre = $fila['nombre'];
                $this->version = $fila['version'];
                $this->fabricante = $fila['fabricante'];
                $this->descripcion = $fila['descripcion'];
                $this->estado = $fila['estado'];
                return 2;
            }
            $this->mensaje = "No se obtuvo la información de la herramienta de desarrollo";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia a la herramienta de desarrollo";
        return 0;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("her_herramienta", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
