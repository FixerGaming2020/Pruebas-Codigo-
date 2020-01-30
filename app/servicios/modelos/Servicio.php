<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Servicio {

    private $id;
    private $sigla;
    private $nombre;
    private $descripcion;
    private $estado;
    private $mensaje;

    public function __construct($id = NULL, $sigla = NULL, $nombre = NULL, $descripcion = NULL, $estado = NULL) {
        $this->id = $id;
        $this->sigla = utf8_decode($sigla);
        $this->nombre = utf8_decode($nombre);
        $this->descripcion = utf8_decode($descripcion);
        $this->estado = $estado;
    }

    public function getId() {
        return $this->id;
    }

    public function getSigla() {
        return utf8_encode($this->sigla);
    }

    public function getNombre() {
        return utf8_encode($this->nombre);
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

    public function setSigla($sigla) {
        $this->sigla = utf8_decode($sigla);
    }

    public function setNombre($nombre) {
        $this->nombre = utf8_decode($nombre);
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = utf8_decode($descripcion);
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function cambiarEstado() {
        if ($this->id && $this->estado) {
            $consulta = "UPDATE srv_servicio SET estado = ? WHERE id = ?";
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
        if ($this->sigla && $this->nombre && $this->descripcion) {
            $consulta = "INSERT INTO srv_servicio OUTPUT INSERTED.id VALUES (?, ?, ?, 'Activo')";
            $datos = array(&$this->sigla, &$this->nombre, &$this->descripcion);
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
        if ($this->id && $this->sigla && $this->nombre && $this->descripcion) {
            $consulta = "UPDATE srv_servicio SET sigla=?, nombre=?, descripcion=? WHERE id=?";
            $datos = array(&$this->sigla, &$this->nombre, &$this->descripcion, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return ($modificacion == 2) ? $this->registrarActividad("MODIFICACION", $this->id) : $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM srv_servicio WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (!is_null($fila)) {
                $this->sigla = $fila['sigla'];
                $this->nombre = $fila['nombre'];
                $this->descripcion = $fila['descripcion'];
                $this->estado = $fila['estado'];
                return 2;
            }
            $this->mensaje = "No se obtuvo la información del servicio";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia al servicio";
        return 0;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("srv_servicio", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
