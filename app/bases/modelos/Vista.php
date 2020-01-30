<?php

/**
 * Description of Vistas
 *
 * @author Emanuel
 */
class Vista {

    private $id;
    private $base;
    private $nombre;
    private $consulta;
    private $descripcion;
    private $fecha;
    private $mensaje;

    public function __construct($id = NULL, $base = NULL, $nombre = NULL, $consulta = NULL, $descripcion = NULL, $fecha = NULL) {
        $this->setId($id);
        $this->setBase($base);
        $this->setNombre($nombre);
        $this->setConsulta($consulta);
        $this->setDescripcion($descripcion);
        $this->setFecha($fecha);
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

    public function getConsulta() {
        return $this->consulta;
    }

    public function getDescripcion() {
        return utf8_encode($this->descripcion);
    }

    public function getFecha() {
        return $this->fecha;
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
        $this->nombre = $nombre;
    }

    public function setConsulta($consulta) {
        $this->consulta = $consulta;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = utf8_decode($descripcion);
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function modificar() {
        if ($this->id && $this->consulta && $this->descripcion) {
            $consulta = "UPDATE bas_vista SET tipoConsulta = ?, descripcion = ? WHERE id = ?";
            $datos = array(&$this->consulta, &$this->descripcion, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = SQLServer::instancia()->getMensaje();
            return($modificacion == 2) ? $this->registrarActividad("MODIFICACION", $this->id) : $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM vwbas_vista WHERE vid = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (gettype($fila) == "array") {
                $this->base = $fila['bnombre'];
                $this->nombre = $fila['vnombre'];
                $this->consulta = $fila['vtipoConsulta'];
                $this->descripcion = $fila['vdescripcion'];
                $this->fecha = $fila['vfechaProceso'];
                return 2;
            }
            $this->mensaje = "No se obtuvo la información de la vista";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia a la vista";
        return 0;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("bas_vistas", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
