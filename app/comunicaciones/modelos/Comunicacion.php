<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Comunicacion {

    private $id;
    private $sigla;
    private $nombre;
    private $cantidad;
    private $gerencia;
    private $delegado;
    private $sitio;
    private $proveedor;
    private $rti;
    private $descripcion;
    private $estado;
    private $mensaje;

    public function __construct($id = NULL, $sigla = NULL, $nombre = NULL, $cantidad = NULL, $gerencia = NULL, $delegado = NULL, $sitio = NULL, $proveedor = NULL, $rti = NULL, $descripcion = NULL, $estado = NULL) {
        $this->id = $id;
        $this->sigla = utf8_decode($sigla);
        $this->nombre = utf8_decode($nombre);
        $this->cantidad = $cantidad;
        $this->gerencia = $gerencia;
        $this->delegado = $delegado;
        $this->sitio = $sitio;
        $this->proveedor = $proveedor;
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

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getGerencia() {
        return $this->gerencia;
    }

    public function getDelegado() {
        return $this->delegado;
    }

    public function getUbicacion() {
        return $this->sitio;
    }

    public function getProveedor() {
        return $this->proveedor;
    }

    public function getRti() {
        return $this->rti;
    }

    public function getDescripcion() {
        return utf8_encode($this->descripcion);
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

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function setGerencia($gerencia) {
        $this->gerencia = $gerencia;
    }

    public function setDelegado($delegado) {
        $this->delegado = $delegado;
    }

    public function setUbicacion($ubicacion) {
        $this->ubicacion = $ubicacion;
    }

    public function setProveedor($proveedor) {
        $this->proveedor = $proveedor;
    }

    public function setRti($rti) {
        $this->rti = $rti;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = utf8_decode($descripcion);
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function cambiarEstado() {
        if ($this->id && $this->estado) {
            $consulta = "UPDATE com_comunicacion SET estado = ? WHERE id = ?";
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
        if ($this->sigla && $this->nombre && $this->cantidad && $this->gerencia && $this->delegado && $this->sitio && $this->proveedor && $this->descripcion && $this->rti) {
            $consulta = "INSERT INTO com_comunicacion OUTPUT INSERTED.id VALUES (? ,?, ?, ?, ?, ?, ?, ?, ?, 'Activa')";
            $datos = array(&$this->sigla, &$this->nombre, &$this->cantidad, &$this->gerencia, &$this->delegado, &$this->sitio, &$this->proveedor, &$this->descripcion, &$this->rti);
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
        if ($this->sigla && $this->nombre && $this->cantidad && $this->gerencia && $this->delegado && $this->sitio && $this->proveedor && $this->descripcion && $this->rti) {
            $consulta = "UPDATE com_comunicacion SET sigla=?, nombre=?, gerencia=?, empleado=?, cantidad=?, sitio=?, proveedor=?, descripcion=?, rti=? WHERE id=?";
            $datos = array(&$this->sigla, &$this->nombre, &$this->gerencia, &$this->delegado, &$this->cantidad, &$this->sitio, &$this->proveedor, &$this->descripcion, &$this->rti, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return ($modificacion == 2) ? $this->registrarActividad("MODIFICACION", $this->id) : $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM com_comunicacion WHERE id = ?";
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
                $pro = $this->obtenerProveedor($fila['proveedor']);
                $del = $this->obtenerEmpleado($fila['empleado']);
                return (($ubi == 2) && ($ger == 2) && ($pro == 2) && ($del == 2)) ? 2 : 1;
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
        $this->delegado = ($resultado == 2) ? $delegado : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener al delegado";
        return $resultado;
    }

    public function obtenerProveedor($idProveedor) {
        $proveedor = new Proveedor($idProveedor);
        $resultado = $proveedor->obtener();
        $this->proveedor = ($resultado == 2) ? $proveedor : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener al proveedor";
        return $resultado;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("com_comunicacion", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
