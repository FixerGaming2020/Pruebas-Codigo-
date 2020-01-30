<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Firewall {

    private $id;
    private $nombre;
    private $marca;
    private $modelo;
    private $nroSerie;
    private $version;
    private $sitio;
    private $ip;
    private $estado;
    private $mensaje;

    public function __construct($id = NULL, $nombre = NULL, $marca = NULL, $modelo = NULL, $nroSerie = NULL, $version = NULL, $sitio = NULL, $ip = NULL, $estado = NULL) {
        $this->id = $id;
        $this->nombre = utf8_decode($nombre);
        $this->marca = utf8_decode($marca);
        $this->modelo = utf8_decode($modelo);
        $this->nroSerie = utf8_decode($nroSerie);
        $this->version = utf8_decode($version);
        $this->sitio = $sitio;
        $this->ip = $ip;
        $this->estado = $estado;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return utf8_encode($this->nombre);
    }

    public function getMarca() {
        return utf8_encode($this->marca);
    }

    public function getModelo() {
        return utf8_encode($this->modelo);
    }

    public function getNroSerie() {
        return utf8_encode($this->nroSerie);
    }

    public function getVersion() {
        return utf8_encode($this->version);
    }

    public function getSitio() {
        return $this->sitio;
    }

    public function getIp() {
        return $this->ip;
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

    public function setMarca($marca) {
        $this->marca = utf8_decode($marca);
    }

    public function setModelo($modelo) {
        $this->modelo = utf8_decode($modelo);
    }

    public function setNroSerie($nroSerie) {
        $this->nroSerie = utf8_decode($nroSerie);
    }

    public function setVersion($version) {
        $this->version = utf8_decode($version);
    }

    public function setSitio($sitio) {
        $this->sitio = $sitio;
    }

    public function setIp($ip) {
        $this->ip = $ip;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function cambiarEstado() {
        if ($this->id && $this->estado) {
            $consulta = "UPDATE fir_firewall SET estado = ? WHERE id = ?";
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
        if ($this->nombre && $this->marca && $this->modelo && $this->nroSerie && $this->version && $this->ip && $this->sitio) {
            $consulta = "INSERT INTO fir_firewall OUTPUT INSERTED.id VALUES (?, ?, ?, ?, ?, ?, ?, 'Activo')";
            $datos = array(&$this->nombre, &$this->marca, &$this->modelo, &$this->nroSerie, &$this->version, &$this->ip, &$this->sitio);
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
        if ($this->nombre && $this->marca && $this->modelo && $this->nroSerie && $this->version && $this->ip && $this->sitio) {
            $consulta = "UPDATE fir_firewall SET nombre=?, marca=?, modelo=?, numeroSerie=?, version=?, ip=?, sitio=? WHERE id=?";
            $datos = array(&$this->nombre, &$this->marca, &$this->modelo, &$this->nroSerie, &$this->version, &$this->ip, &$this->sitio, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return ($modificacion == 2) ? $this->registrarActividad("MODIFICACION", $this->id) : $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM fir_firewall WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (gettype($fila) == "array") {
                $this->nombre = $fila['nombre'];
                $this->marca = $fila['marca'];
                $this->modelo = $fila['modelo'];
                $this->nroSerie = $fila['numeroSerie'];
                $this->version = $fila['version'];
                $this->ip = $fila['ip'];
                $this->estado = $fila['estado'];
                return $this->obtenerSitio($fila['sitio']);
            }
            $this->mensaje = "No se obtuvo la información del firewall";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia al firewall";
        return 0;
    }

    private function obtenerSitio($idSitio) {
        $sitio = new Sitio($idSitio);
        $resultado = $sitio->obtener();
        $this->sitio = ($resultado == 2) ? $sitio : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener la ubicacion";
        return $resultado;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("fir_firewall", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
