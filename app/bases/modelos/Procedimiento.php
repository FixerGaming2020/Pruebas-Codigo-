<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Procedimiento {

    private $id;
    private $base;
    private $nombre;
    private $definicion;
    private $fechaCreacion;
    private $fechaEdicion;
    private $descripcion;
    private $fechaProceso;
    private $mensaje;

    public function __construct($id = NULL, $base = NULL, $nombre = NULL, $definicion = NULL, $fechaCreacion = NULL, $fechaEdicion = NULL, $descripcion = NULL, $fechaProceso = NULL) {
        $this->id = $id;
        $this->base = $base;
        $this->nombre = utf8_decode($nombre);
        $this->definicion = utf8_decode($definicion);
        $this->fechaCreacion = $fechaCreacion;
        $this->fechaEdicion = $fechaEdicion;
        $this->descripcion = utf8_decode($descripcion);
        $this->fechaProceso = $fechaProceso;
    }

    public function getId() {
        return $this->id;
    }

    public function getBase() {
        return $this->base;
    }

    public function getNombre() {
        return utf8_encode($this->nombre);
    }

    public function getDefinicion() {
        return utf8_encode($this->definicion);
    }

    public function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    public function getFechaEdicion() {
        return $this->fechaEdicion;
    }

    public function getDescripcion() {
        return utf8_encode($this->descripcion);
    }

    public function getFechaProceso() {
        return $this->fechaProceso;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setBase($base) {
        $this->base = $base;
    }

    public function setNombre($nombre) {
        $this->nombre = utf8_decode($nombre);
    }

    public function setDefinicion($definicion) {
        $this->definicion = utf8_decode($definicion);
    }

    public function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    public function setFechaEdicion($fechaEdicion) {
        $this->fechaEdicion = $fechaEdicion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = utf8_decode($descripcion);
    }

    public function setFechaProceso($fechaProceso) {
        $this->fechaProceso = $fechaProceso;
    }

    public function modificar() {
        if ($this->id && $this->descripcion) {
            $consulta = "UPDATE bas_procedimiento SET descripcion = ? WHERE id = ?";
            $datos = array(&$this->descripcion, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = SQLServer::instancia()->getMensaje();
            return ($modificacion == 2) ? $this->registrarActividad("MODIFICACION", $this->id) : $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM vwbas_procedimiento WHERE pid = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (!is_null($fila)) {
                $this->base = $fila['bnombre'];
                $this->nombre = $fila['pnombre'];
                $this->definicion = $fila['prutina'];
                $this->fechaCreacion = $fila['pfechaCreacion'];
                $this->fechaEdicion = $fila['pfechaEdicion'];
                $this->descripcion = $fila['pdescripcion'];
                $this->fechaProceso = $fila['pfechaProceso'];
                return 2;
            }
            $this->mensaje = "No se obtuvo la información del procedimiento";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia al procedimiento";
        return 0;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("bas_procedimiento", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
