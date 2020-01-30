<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Sitio {

    /** @var string Identidicador [NVARCHAR(10)] */
    private $id;

    /** @var string Tipo de sitio entre CPP, URP o SUC [NVARCHAR(10)] */
    private $tipo;

    /** @var string Nombre del sitio [NVARCHAR(50)] */
    private $nombre;

    /** @var string Nombre de la provincia [NVARCHAR(50)] */
    private $provincia;

    /** @var string Nombre de la ciudad [NVARCHAR(50)] */
    private $ciudad;

    /** @var bigint Codigo postal [BIGINT] */
    private $codigoPostal;

    /** @var string Direccion del sitio [NVARCHAR(60)] */
    private $direccion;

    /** @var string Origen entre Tercerizado o Propio [NVARCHAR(10)] */
    private $origen;

    /** @var integer Estado entre 0 o 1 [INT] */
    private $estado;

    /** @var string Mensaje que describe el estado del objeto u operacion */
    private $mensaje;

    public function __construct($id = NULL, $tipo = NULL, $nombre = NULL, $provincia = NULL, $ciudad = NULL, $codigoPostal = NULL, $direccion = NULL, $origen = NULL, $estado = NULL) {
        $this->id = $id;
        $this->tipo = utf8_decode($tipo);
        $this->nombre = utf8_decode($nombre);
        $this->provincia = utf8_decode($provincia);
        $this->ciudad = utf8_decode($ciudad);
        $this->codigoPostal = $codigoPostal;
        $this->direccion = utf8_decode($direccion);
        $this->origen = $origen;
        $this->estado = $estado;
    }

    public function getId() {
        return $this->id;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getNombre() {
        return utf8_encode($this->nombre);
    }

    public function getProvincia() {
        return utf8_encode($this->provincia);
    }

    public function getCiudad() {
        return utf8_encode($this->ciudad);
    }

    public function getCodigoPostal() {
        return $this->codigoPostal;
    }

    public function getDireccion() {
        return utf8_encode($this->direccion);
    }

    public function getOrigen() {
        return $this->origen;
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
        $this->tipo = $tipo;
    }

    public function setNombre($nombre) {
        $this->nombre = utf8_decode($nombre);
    }

    public function setProvincia($provincia) {
        $this->provincia = utf8_decode($provincia);
    }

    public function setCiudad($ciudad) {
        $this->ciudad = utf8_decode($ciudad);
    }

    public function setCodigoPostal($codigoPostal) {
        $this->codigoPostal = $codigoPostal;
    }

    public function setDireccion($direccion) {
        $this->direccion = utf8_decode($direccion);
    }

    public function setOrigen($origen) {
        $this->origen = $origen;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function cambiarEstado() {
        if ($this->id && $this->estado) {
            $consulta = "UPDATE sit_sitio SET estado = ? WHERE id = ?";
            $modificacion = SQLServer::instancia()->modificar($consulta, array(&$this->estado, &$this->id));
            $this->mensaje = SQLServer::instancia()->getMensaje();
            if ($modificacion == 2) {
                $operacion = ($this->estado == 'Activo') ? "ALTA" : "BAJA";
                $modificacion = $this->registrarActividad($operacion, $this->id);
            }
            return $modificacion;
        }
        $this->descripcion = "No se recibieron todos los parametros obligatorios";
        return 0;
    }

    public function crear() {
        if ($this->id && $this->tipo && $this->nombre) {
            $consulta = "INSERT INTO sit_sitio VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Activo')";
            $datos = array($this->id, $this->tipo, $this->nombre, $this->provincia, $this->ciudad, $this->codigoPostal, $this->direccion, $this->origen);
            $creacion = SQLServer::instancia()->insertar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            if ($creacion == 2) {
                $creacion = $this->registrarActividad("CREACION", $this->id);
            }
            return $creacion;
        }
        $this->mensaje = "No se recibieron todos los parametros obligatorios";
        return 0;
    }

    public function modificar() {
        if ($this->id && $this->tipo && $this->nombre) {
            $consulta = "UPDATE sit_sitio SET nombre=?, tipo=?, provincia=?, ciudad=?, codigoPostal=?, direccion=?, origen=? WHERE id=?";
            $datos = array(&$this->nombre, &$this->tipo, &$this->provincia, &$this->ciudad, &$this->codigoPostal, &$this->direccion, &$this->origen, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return ($modificacion == 2) ? $this->registrarActividad("MODIFICACION", $this->id) : $modificacion;
        }
        $this->mensaje = "No se recibieron todos los parametros obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM sit_sitio WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (gettype($fila) == "array") {
                $this->tipo = $fila['tipo'];
                $this->nombre = $fila['nombre'];
                $this->provincia = $fila['provincia'];
                $this->ciudad = $fila['ciudad'];
                $this->codigoPostal = $fila['codigoPostal'];
                $this->direccion = $fila['direccion'];
                $this->origen = $fila['origen'];
                $this->estado = $fila['estado'];
                return 2;
            }
            $this->mensaje = "No se pudo obtener la información del sitio";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia al sitio";
        return 0;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("sit_sitio", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
