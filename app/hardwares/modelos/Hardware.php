<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Hardware {

    private $id;
    private $tipo;
    private $sigla;
    private $nombre;
    private $dominio;
    private $swBase;
    private $ambiente;
    private $funcion;
    private $sitio;
    private $marca;
    private $modelo;
    private $arquitectura;
    private $core;
    private $procesador;
    private $mhz;
    private $memoria;
    private $disco;
    private $raid;
    private $red;
    private $rti;
    private $estado;
    private $mensaje;

    public function __construct($id = NULL, $tipo = NULL, $sigla = NULL, $nombre = NULL, $dominio = NULL, $swBase = NULL, $ambiente = NULL, $funcion = NULL, $sitio = NULL, $marca = NULL, $modelo = NULL, $arquitectura = NULL, $core = NULL, $procesador = NULL, $mhz = NULL, $memoria = NULL, $disco = NULL, $raid = NULL, $red = NULL, $rti = NULL, $estado = NULL) {
        $this->id = $id;
        $this->tipo = $tipo;
        $this->sigla = utf8_decode($sigla);
        $this->nombre = utf8_decode($nombre);
        $this->dominio = $dominio;
        $this->swBase = utf8_decode($swBase);
        $this->ambiente = utf8_decode($ambiente);
        $this->funcion = utf8_decode($funcion);
        $this->sitio = $sitio;
        $this->marca = utf8_decode($marca);
        $this->modelo = utf8_decode($modelo);
        $this->arquitectura = utf8_decode($arquitectura);
        $this->core = $core;
        $this->procesador = utf8_decode($procesador);
        $this->mhz = $mhz;
        $this->memoria = $memoria;
        $this->disco = $disco;
        $this->raid = $raid;
        $this->red = $red;
        $this->rti = $rti;
        $this->estado = $estado;
    }

    public function getId() {
        return $this->id;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getSigla() {
        return $this->sigla;
    }

    public function getNombre() {
        return utf8_encode($this->nombre);
    }

    public function getDominio() {
        return $this->dominio;
    }

    public function getSwBase() {
        return utf8_encode($this->swBase);
    }

    public function getAmbiente() {
        return $this->ambiente;
    }

    public function getFuncion() {
        return utf8_encode($this->funcion);
    }

    public function getSitio() {
        return $this->sitio;
    }

    public function getMarca() {
        return utf8_encode($this->marca);
    }

    public function getModelo() {
        return utf8_encode($this->modelo);
    }

    public function getArquitectura() {
        return utf8_encode($this->arquitectura);
    }

    public function getCore() {
        return utf8_encode($this->core);
    }

    public function getProcesador() {
        return utf8_encode($this->procesador);
    }

    public function getMhz() {
        return ($this->mhz = "NULL") ? NULL : $this->mhz;
    }

    public function getMemoria() {
        return ($this->memoria = "NULL") ? NULL : $this->memoria;
    }

    public function getDisco() {
        return utf8_encode($this->disco);
    }

    public function getRaid() {
        return utf8_encode($this->raid);
    }

    public function getRed() {
        return ($this->red = "NULL") ? NULL : $this->red;
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

    public function setTipo($tipo) {
        $this->tipo = utf8_decode($tipo);
    }

    public function setSigla($sigla) {
        $this->sigla = $sigla;
    }

    public function setNombre($nombre) {
        $this->nombre = utf8_decode($nombre);
    }

    public function setDominio($dominio) {
        $this->dominio = $dominio;
    }

    public function setSwBase($swBase) {
        $this->swBase = $swBase;
    }

    public function setAmbiente($ambiente) {
        $this->ambiente = $ambiente;
    }

    public function setFuncion($funcion) {
        $this->funcion = utf8_decode($funcion);
    }

    public function setSitio($sitio) {
        $this->sitio = $sitio;
    }

    public function setMarca($marca) {
        $this->marca = utf8_decode($marca);
    }

    public function setModelo($modelo) {
        $this->modelo = utf8_decode($modelo);
    }

    public function setArquitectura($arquitectura) {
        $this->arquitectura = utf8_decode($arquitectura);
    }

    public function setCore($core) {
        $this->core = utf8_decode($core);
    }

    public function setProcesador($procesador) {
        $this->procesador = utf8_decode($procesador);
    }

    public function setMhz($mhz) {
        $this->mhz = ($mhz) ? $mhz : "NULL";
    }

    public function setMemoria($memoria) {
        $this->memoria = ($memoria) ? $memoria : "NULL";
    }

    public function setDisco($disco) {
        $this->disco = utf8_decode($disco);
    }

    public function setRaid($raid) {
        $this->raid = utf8_decode($raid);
    }

    public function setRed($red) {
        $this->red = ($red) ? $red : "NULL";
    }

    public function setRti($rti) {
        $this->rti = $rti;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function cambiarEstado() {
        if ($this->id && $this->estado) {
            $consulta = "UPDATE har_hardware SET estado = ? WHERE id = ?";
            $modificacion = SQLServer::instancia()->modificar($consulta, array(&$this->estado, &$this->id));
            $this->mensaje = SQLServer::instancia()->getMensaje();
            if ($modificacion == 2) {
                $operacion = ($this->estado == "Activo") ? "ALTA" : "BAJA";
                $modificacion = $this->registrarActividad($operacion, $this->id);
            }
            return $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function crear() {
        if ($this->tipo && $this->ambiente && $this->sigla && $this->nombre && $this->sitio && $this->dominio && $this->rti) {
            $consulta = "INSERT INTO har_hardware OUTPUT INSERTED.id  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,'Activo')";
            $datos = array(&$this->tipo, &$this->sigla, &$this->nombre, &$this->dominio, &$this->swBase, &$this->ambiente, &$this->funcion,
                &$this->sitio, &$this->marca, &$this->modelo, &$this->arquitectura, &$this->core, &$this->procesador, &$this->mhz, &$this->memoria,
                &$this->disco, &$this->raid, &$this->red, &$this->rti);
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
        if ($this->id && $this->tipo && $this->ambiente && $this->sigla && $this->nombre && $this->sitio && $this->dominio && $this->rti) {
            $consulta = "UPDATE har_hardware SET tipo=?, sigla=?, nombre=?, dominio=?, softwareBase=?, ambiente=?, funcion=?, sitio=?, arquitectura=?, core=?, procesador=?, mhz=?, memoria=?, disco=?, raid=?, red=?, rti=? WHERE id = ?";
            $datos = array(&$this->tipo, &$this->sigla, &$this->nombre, &$this->dominio, &$this->swBase, &$this->ambiente, &$this->funcion,
                &$this->sitio, &$this->marca, &$this->modelo, &$this->arquitectura, &$this->core, &$this->procesador, &$this->mhz, &$this->memoria,
                &$this->disco, &$this->raid, &$this->red, &$this->rti, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return ($modificacion == 2) ? $this->registrarActividad("MODIFICACION", $this->id) : $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM har_hardware WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (gettype($fila) == "array") {
                $this->tipo = $fila['tipo'];
                $this->sigla = $fila['sigla'];
                $this->nombre = $fila['nombre'];
                $this->dominio = $fila['dominio'];
                $this->swBase = $fila['softwareBase'];
                $this->ambiente = $fila['ambiente'];
                $this->funcion = $fila['funcion'];
                $this->arquitectura = $fila['arquitectura'];
                $this->core = $fila['core'];
                $this->procesador = $fila['procesador'];
                $this->mhz = $fila['mhz'];
                $this->memoria = $fila['memoria'];
                $this->disco = $fila['disco'];
                $this->raid = $fila['raid'];
                $this->red = $fila['red'];
                $this->rti = $fila['rti'];
                $this->estado = $fila['estado'];
                return $this->obtenerSitio($fila['sitio']);
            }
            $this->mensaje = "No se obtuvo la información del hardware";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia al hardware";
        return 0;
    }

    private function obtenerSitio($idSitio) {
        $sitio = new Sitio($idSitio);
        $resultado = $sitio->obtener();
        $this->sitio = ($resultado == 2) ? $sitio : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener el sitio";
        return $resultado;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("har_hardware", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
