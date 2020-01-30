<?php

class Tabla {

    private $id;
    private $base;
    private $objeto;
    private $nombre;
    private $descripcion;
    private $fechaCreacion;
    private $fechaEdicion;
    private $campos;
    private $fechaProceso;
    private $mensaje;

    public function __construct($id = NULL, $base = NULL, $objeto = NULL, $nombre = NULL, $descripcion = NULL, $fechaCreacion = NULL, $fechaEdicion = NULL, $fechaProceso = NULL) {
        $this->id = $id;
        $this->base = $base;
        $this->objeto = $objeto;
        $this->nombre = utf8_decode($nombre);
        $this->descripcion = utf8_decode($descripcion);
        $this->fechaCreacion = $fechaCreacion;
        $this->fechaEdicion = $fechaEdicion;
        $this->fechaProceso = $fechaProceso;
    }

    public function getId() {
        return $this->id;
    }

    public function getBase() {
        return $this->base;
    }

    public function getObjeto() {
        return $this->objeto;
    }

    public function getNombre() {
        return utf8_encode($this->nombre);
    }

    public function getDescripcion() {
        return utf8_encode($this->descripcion);
    }

    public function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    public function getFechaEdicion() {
        return $this->fechaEdicion;
    }

    public function getCampos() {
        return $this->campos;
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

    public function setObjeto($objeto) {
        $this->objeto = $objeto;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    public function setFechaEdicion($fechaEdicion) {
        $this->fechaEdicion = $fechaEdicion;
    }

    public function setCampos($campos) {
        $this->campos = $campos;
    }

    public function setFechaProceso($fechaProceso) {
        $this->fechaProceso = $fechaProceso;
    }

    public function modificar() {
        if ($this->id && $this->descripcion) {
            $consulta = "UPDATE bas_tabla SET descripcion = ? WHERE id = ?";
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
            $consulta = "SELECT * FROM vwbas_tabla WHERE tid = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (!is_null($fila)) {
                $this->base = $fila['bnombre'];
                $this->nombre = $fila['tnombre'];
                $this->descripcion = $fila['tdescripcion'];
                $this->fechaCreacion = $fila['tfechaCreacion'];
                $this->fechaEdicion = $fila['tfechaEdicion'];
                $this->fechaProceso = $fila['tfechaProceso'];
                $this->campos = $fila['campos'];
                return 2;
            }
            $this->mensaje = "No se obtuvo la información de la tabla";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia a la tabla";
        return 0;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("bas_tablas", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
