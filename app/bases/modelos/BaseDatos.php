<?php

class BaseDatos {

    private $id;
    private $nombre;
    private $produccion;
    private $test;
    private $desarrollo;
    private $creacion;
    private $motor;
    private $collation;
    private $proceso;
    private $rti;
    private $estado;
    private $mensaje;

    public function __construct($id = NULL, $nombre = NULL, $produccion = NULL, $test = NULL, $desarrollo = NULL, $creacion = NULL, $motor = NULL, $collation = NULL, $proceso = NULL, $rti = NULL, $estado = NULL) {
        $this->id = $id;
        $this->nombre = utf8_decode($nombre);
        $this->produccion = $produccion;
        $this->test = $test;
        $this->desarrollo = $desarrollo;
        $this->creacion = $creacion;
        $this->motor = utf8_decode($motor);
        $this->collation = utf8_decode($collation);
        $this->proceso = $proceso;
        $this->rti = $rti;
        $this->estado = $estado;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return utf8_encode($this->nombre);
    }

    public function getProduccion() {
        return $this->produccion;
    }

    public function getTest() {
        return $this->test;
    }

    public function getDesarrollo() {
        return $this->desarrollo;
    }

    public function getCreacion() {
        return $this->creacion;
    }

    public function getMotor() {
        return utf8_encode($this->motor);
    }

    public function getCollation() {
        return utf8_encode($this->collation);
    }

    public function getProceso() {
        return $this->proceso;
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

    public function setProduccion($produccion) {
        $this->produccion = $produccion;
    }

    public function setTest($test) {
        $this->test = $test;
    }

    public function setDesarrollo($desarrollo) {
        $this->desarrollo = $desarrollo;
    }

    public function setCreacion($creacion) {
        $this->creacion = $creacion;
    }

    public function setMotor($motor) {
        $this->motor = utf8_decode($motor);
    }

    public function setCollation($collation) {
        $this->collation = utf8_decode($collation);
    }

    public function setProceso($proceso) {
        $this->proceso = $proceso;
    }

    public function setRti($rti) {
        $this->rti = $rti;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function modificar() {
        if ($this->id && $this->rti && $this->test && $this->desarrollo) {
            $consulta = "UPDATE bas_base SET rti = ?, test = ?, desarrollo = ? WHERE id = ?";
            $datos = array(&$this->rti, &$this->test, &$this->desarrollo, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = SQLServer::instancia()->getMensaje();
            return ($modificacion == 2) ? $this->registrarActividad("MODIFICACION", $this->id) : $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("bas_base", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
