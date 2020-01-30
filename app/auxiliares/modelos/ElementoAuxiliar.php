<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ElementoAuxiliar {

    private $id;
    private $sigla;
    private $nombre;
    private $gerencia;
    private $empleado;
    private $sitio;
    private $cantidad;
    private $descripcion;
    private $rti;
    private $estado;
    private $mensaje;

    public function __construct($id = NULL, $sigla = NULL, $nombre = NULL, $gerencia = NULL, $empleado = NULL, $sitio = NULL, $cantidad = NULL, $descripcion = NULL, $rti = NULL, $estado = NULL) {
        $this->id = $id;
        $this->sigla = utf8_decode($sigla);
        $this->nombre = utf8_decode($nombre);
        $this->gerencia = $gerencia;
        $this->empleado = $empleado;
        $this->sitio = $sitio;
        $this->cantidad = $cantidad;
        $this->descripcion = utf8_decode($descripcion);
        $this->rti = $rti;
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

    public function getGerencia() {
        return $this->gerencia;
    }

    public function getEmpleado() {
        return $this->empleado;
    }

    public function getSitio() {
        return $this->sitio;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getDescripcion() {
        return utf8_encode($this->descripcion);
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

    public function setSigla($sigla) {
        $this->sigla = utf8_decode($sigla);
    }

    public function setNombre($nombre) {
        $this->nombre = utf8_decode($nombre);
    }

    public function setGerencia($gerencia) {
        $this->gerencia = $gerencia;
    }

    public function setEmpleado($empleado) {
        $this->empleado = $empleado;
    }

    public function setSitio($sitio) {
        $this->sitio = $sitio;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = utf8_decode($descripcion);
    }

    public function setRti($rti) {
        $this->rti = $rti;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function cambiarEstado() {
        if ($this->id && $this->estado) {
            $consulta = "UPDATE aux_auxiliar SET estado = ? WHERE id = ?";
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
        if ($this->sigla && $this->nombre && $this->gerencia && $this->empleado && $this->sitio && $this->cantidad && $this->descripcion && $this->rti) {
            $consulta = "INSERT INTO aux_auxiliar OUTPUT INSERTED.id VALUES (? ,?, ?, ?, ?, ?, ?, ?, 'Activo')";
            $datos = array(&$this->sigla, &$this->nombre, &$this->cantidad, &$this->gerencia, &$this->empleado, &$this->sitio, &$this->descripcion, &$this->rti);
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
        if ($this->sigla && $this->nombre && $this->cantidad && $this->gerencia && $this->empleado && $this->sitio && $this->descripcion && $this->rti) {
            $consulta = "UPDATE aux_auxiliar SET sigla=?, nombre=?, gerencia=?, empleado=?, cantidad=?, sitio=?, descripcion=?, rti=? WHERE id=?";
            $datos = array(&$this->sigla, &$this->nombre, &$this->gerencia, &$this->empleado, &$this->cantidad, &$this->sitio, &$this->descripcion, &$this->rti, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return ($modificacion == 2) ? $this->registrarActividad("MODIFICACION", $this->id) : $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM aux_auxiliar WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (gettype($fila) == "array") {
                $this->sigla = $fila['sigla'];
                $this->nombre = $fila['nombre'];
                $this->cantidad = $fila['cantidad'];
                $this->descripcion = $fila['descripcion'];
                $this->rti = $fila['rti'];
                $this->estado = $fila['estado'];
                $ubi = $this->obtenerSitio($fila['sitio']);
                $ger = $this->obtenerGerencia($fila['gerencia']);
                $del = $this->obtenerEmpleado($fila['empleado']);
                return (($ubi == 2) && ($ger == 2) && ($del == 2)) ? 2 : 1;
            }
            $this->mensaje = "No se pudo obtener la información de la comunicación";
            return 1;
        }
        $this->descripcion = "No se pudo hacer referencia a la comunicación";
        return 0;
    }

    private function obtenerGerencia($idGerencia) {
        $gerencia = new Gerencia($idGerencia);
        $resultado = $gerencia->obtener();
        $this->gerencia = ($resultado == 2) ? $gerencia : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener la gerencia";
        return $resultado;
    }

    private function obtenerSitio($idSitio) {
        $ubicacion = new Sitio($idSitio);
        $resultado = $ubicacion->obtener();
        $this->sitio = ($resultado == 2) ? $ubicacion : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener la ubicación";
        return $resultado;
    }

    public function obtenerEmpleado($idDelegado) {
        $delegado = new Empleado($idDelegado);
        $resultado = $delegado->obtener(TRUE);
        $this->empleado = ($resultado == 2) ? $delegado : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener al delegado";
        return $resultado;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("com_comunicacion", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
