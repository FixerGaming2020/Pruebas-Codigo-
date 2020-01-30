<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Instalacion {

    private $id;
    private $sigla;
    private $nombre;
    private $gerencia;
    private $empleado;
    private $sitio;
    private $plataforma;
    private $rti;
    private $descripcion;
    private $estado;
    private $mensaje;

    public function __construct($id = NULL, $sigla = NULL, $nombre = NULL, $gerencia = NULL, $descripcion = NULL, $plataforma = NULL, $empleado = NULL, $sitio = NULL, $rti = NULL, $estado = NULL) {
        $this->id = $id;
        $this->sigla = utf8_decode($sigla);
        $this->nombre = utf8_decode($nombre);
        $this->gerencia = $gerencia;
        $this->empleado = $empleado;
        $this->sitio = $sitio;
        $this->plataforma = $plataforma;
        $this->rti = $rti;
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

    public function getGerencia() {
        return $this->gerencia;
    }

    public function getDescripcion() {
        return utf8_encode($this->descripcion);
    }

    public function getPlataforma() {
        return $this->plataforma;
    }

    public function getEmpleado() {
        return $this->empleado;
    }

    public function getSitio() {
        return $this->sitio;
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

    public function setDescripcion($descripcion) {
        $this->descripcion = utf8_decode($descripcion);
    }

    public function setPlataforma($plataforma) {
        $this->plataforma = $plataforma;
    }

    public function setEmpleado($empleado) {
        $this->empleado = $empleado;
    }

    public function setUbicacion($sitio) {
        $this->sitio = $sitio;
    }

    public function setRti($rti) {
        $this->rti = $rti;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function cambiarEstado() {
        if ($this->id && $this->estado) {
            $consulta = "UPDATE ins_instalacion SET estado = ? WHERE id = ?";
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
        if ($this->sigla && $this->nombre && $this->gerencia && $this->empleado && $this->sitio) {
            $consulta = "INSERT INTO ins_instalacion OUTPUT INSERTED.id VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Activa')";
            $datos = array(&$this->sigla, &$this->nombre, &$this->gerencia, &$this->empleado, &$this->sitio, &$this->plataforma, &$this->rti, &$this->descripcion);
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
        if ($this->sigla && $this->nombre && $this->gerencia && $this->empleado && $this->sitio) {
            $consulta = "UPDATE ins_instalacion SET sigla=?, nombre=?, gerencia=?, empleado=?, sitio=?, plataforma=?, rti=?, descripcion=? WHERE id=?";
            $datos = array(&$this->sigla, &$this->nombre, &$this->gerencia, &$this->empleado, &$this->sitio, &$this->plataforma, &$this->rti, &$this->descripcion, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return ($modificacion == 2) ? $this->registrarActividad("MODIFICACION", $this->id) : $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM ins_instalacion WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (gettype($fila) == "array") {
                $this->sigla = $fila['sigla'];
                $this->nombre = $fila['nombre'];
                $this->descripcion = $fila['descripcion'];
                $this->rti = $fila['rti'];
                $plataforma = $this->obtenerPlataforma($fila['plataforma']);
                $gerencia = $this->obtenerGerencia($fila['gerencia']);
                $ubicacion = $this->obtenerSitio($fila['sitio']);
                $responsable = $this->obtenerEmpleado($fila['empleado']);
                return (($plataforma == 2) && ($gerencia == 2) && ($ubicacion == 2) && ($responsable == 2)) ? 2 : 1;
            }
            $this->mensaje = "No se obtuvo la información de la instalación";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia a la instalación";
        return 0;
    }

    private function obtenerPlataforma($idPlataforma) {
        $plataforma = new PlataformaSO($idPlataforma);
        $resultado = $plataforma->obtener();
        $this->plataforma = ($resultado == 2) ? $plataforma : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener la plataforma";
        return $resultado;
    }

    private function obtenerGerencia($idGerencia) {
        $gerencia = new Gerencia($idGerencia);
        $resultado = $gerencia->obtener();
        $this->gerencia = ($resultado == 2) ? $gerencia : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener la gerencia";
        return $resultado;
    }

    private function obtenerEmpleado($idEmpleado) {
        $empleado = new Empleado($idEmpleado);
        $resultado = $empleado->obtener(TRUE);
        $this->empleado = ($resultado == 2) ? $empleado : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener el responsable";
        return $resultado;
    }

    private function obtenerSitio($idSitio) {
        $sitio = new Sitio($idSitio);
        $resultado = $sitio->obtener();
        $this->sitio = ($resultado == 2) ? $sitio : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener el sitio";
        return $resultado;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("ins_instalacion", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
