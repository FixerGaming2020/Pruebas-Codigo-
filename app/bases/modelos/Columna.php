<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Columna {

    private $id;
    private $tabla;
    private $nombre;
    private $nulos;
    private $tipo;
    private $maximo;
    private $descripcion;
    private $fechaProceso;
    private $mensaje;

    public function __construct($id = NULL, $tabla = NULL, $nombre = NULL, $nulos = NULL, $tipo = NULL, $maximo = NULL, $descripcion = NULL, $fechaProceso = NULL) {
        $this->id = $id;
        $this->tabla = $tabla;
        $this->nombre = utf8_decode($nombre);
        $this->nulos = utf8_decode($nulos);
        $this->tipo = utf8_decode($tipo);
        $this->maximo = $maximo;
        $this->descripcion = utf8_decode($descripcion);
        $this->fechaProceso = $fechaProceso;
    }

    public function getId() {
        return $this->id;
    }

    public function getTabla() {
        return $this->tabla;
    }

    public function getNombre() {
        return utf8_encode($this->nombre);
    }

    public function getNulos() {
        return utf8_encode($this->nulos);
    }

    public function getTipo() {
        return utf8_encode($this->tipo);
    }

    public function getMaximo() {
        return $this->maximo;
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

    public function setTabla($tabla) {
        $this->tabla = $tabla;
    }

    public function setNombre($nombre) {
        $this->nombre = utf8_decode($nombre);
    }

    public function setNulos($nulos) {
        $this->nulos = utf8_decode($nulos);
    }

    public function setTipo($tipo) {
        $this->tipo = utf8_decode($tipo);
    }

    public function setMaximo($maximo) {
        $this->maximo = $maximo;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = utf8_decode($descripcion);
    }

    public function setFechaProceso($fechaProceso) {
        $this->fechaProceso = $fechaProceso;
    }

    public function modificar() {
        if ($this->id && $this->descripcion) {
            $consulta = "UPDATE bas_columna SET descripcion = ? WHERE id = ?";
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
            $consulta = "SELECT * FROM vwbas_columna WHERE cid = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (gettype($fila) == "array") {
                $this->tabla = $fila['tnombre'];
                $this->nombre = $fila['cnombre'];
                $this->nulos = $fila['cnulos'];
                $this->tipo = $fila['ctipo'];
                $this->maximo = $fila['cmaximo'];
                $this->descripcion = $fila['cdescripcion'];
                $this->fechaProceso = $fila['cfechaProceso'];
                return 2;
            }
            $this->mensaje = "No se obtuvo la información de la columna";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia a la columna";
        return 0;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("bas_columna", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
