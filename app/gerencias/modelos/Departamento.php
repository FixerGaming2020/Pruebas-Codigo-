<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Departamento {

    private $id;
    private $nombre;
    private $gerencia;
    private $estado;
    private $mensaje;

    public function __construct($id = NULL, $nombre = NULL, $gerencia = NULL, $estado = NULL) {
        $this->id = $id;
        $this->nombre = utf8_decode($nombre);
        $this->gerencia = $gerencia;
        $this->estado = $estado;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return utf8_encode($this->nombre);
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getGerencia() {
        return $this->gerencia;
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

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setGerencia($gerencia) {
        $this->gerencia = $gerencia;
    }

    public function cambiarEstado() {
        if ($this->id && $this->estado) {
            $consulta = "UPDATE ger_departamento SET estado = ? WHERE id = ?";
            $modificacion = SQLServer::instancia()->modificar($consulta, array(&$this->estado, &$this->id));
            $this->mensaje = SQLServer::instancia()->getMensaje();
            if ($modificacion == 2) {
                $operacion = ($this->estado == 'Activo') ? "ALTA" : "BAJA";
                $modificacion = $this->registrarActividad($operacion, $this->id);
            }
            return $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorioss";
        return 0;
    }

    public function crear() {
        if ($this->nombre && $this->gerencia) {
            $consulta = "INSERT INTO ger_departamento OUTPUT INSERTED.id VALUES (?, ?, 'Activo')";
            $datos = array(&$this->nombre, &$this->gerencia);
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
        if ($this->id && $this->nombre && $this->gerencia) {
            $consulta = "UPDATE ger_departamento SET nombre=?, gerencia=? WHERE id=?";
            $datos = array(&$this->nombre, &$this->gerencia, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return ($modificacion == 2) ? $modificacion : $this->registrarActividad("MODIFICACION", $this->id);
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM ger_departamento WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (gettype($fila) == "array") {
                $this->nombre = $fila['nombre'];
                $this->estado = $fila['estado'];
                return $this->obtenerGerencia($fila['gerencia']);
            }
            $this->mensaje = "No se obtuvo la información del departamento";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia al departamento";
        return 0;
    }

    private function obtenerGerencia($idGerencia) {
        $gerencia = new Gerencia($idGerencia);
        $resultado = $gerencia->obtener();
        $this->gerencia = ($resultado == 2) ? $gerencia : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener la gerencia";
        return $resultado;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("ger_departamento", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
