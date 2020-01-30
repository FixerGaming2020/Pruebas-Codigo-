<?php

class Servidor {

    private $ip;
    private $nombre;
    private $ambiente;
    private $tipo;
    private $descripcion;
    private $estado;
    private $mensaje;

    public function __construct($ip = NULL, $nombre = NULL, $ambiente = NULL, $tipo = NULL, $descripcion = NULL, $estado = NULL) {
        $this->ip = $ip;
        $this->nombre = utf8_decode($nombre);
        $this->ambiente = utf8_decode($ambiente);
        $this->tipo = utf8_decode($tipo);
        $this->descripcion = utf8_decode($descripcion);
        $this->estado = $estado;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getIp() {
        return $this->ip;
    }

    public function getAmbiente() {
        return utf8_encode($this->ambiente);
    }

    public function getTipo() {
        return utf8_encode($this->tipo);
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

    public function setNombre($nombre) {
        $this->nombre = utf8_decode($nombre);
    }

    public function setIp($ip) {
        $this->ip = $ip;
    }

    public function setAmbiente($ambiente) {
        $this->ambiente = utf8_decode($ambiente);
    }

    public function setTipo($tipo) {
        $this->tipo = utf8_decode($tipo);
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = utf8_decode($descripcion);
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function cambiarEstado() {
        if ($this->ip && $this->estado) {
            $consulta = "UPDATE ser_servidor SET estado = ? WHERE id = ?";
            $modificacion = SQLServer::instancia()->modificar($consulta, array(&$this->estado, &$this->ip));
            $this->mensaje = SQLServer::instancia()->getMensaje();
            if ($modificacion == 2) {
                $operacion = ($this->estado == 'Activo') ? "ALTA" : "BAJA";
                $modificacion = $this->registrarActividad($operacion, $this->ip);
            }
            return $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function crear() {
        if ($this->ip && $this->nombre && $this->ambiente && $this->tipo && $this->descripcion) {
            $consulta = "INSERT INTO ser_servidor VALUES (?, ?, ?, ?, ?, 0, 0, 'Activo')";
            $datos = array(&$this->ip, &$this->nombre, &$this->ambiente, &$this->tipo, &$this->descripcion);
            $creacion = SQLServer::instancia()->insertar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ': ' . SQLServer::instancia()->getMensaje();
            if ($creacion == 2) {
                $creacion = $this->registrarActividad("CREACION", $this->ip);
            }
            return $creacion;
        }
        $this->mensaje = "No se recibieron todos los campos obligatorios";
        return 0;
    }

    public function modificar($ipOriginal) {
        if ($this->ip && $this->nombre && $this->ambiente && $this->tipo && $this->descripcion) {
            $consulta = "UPDATE ser_servidor SET id = ?, nombre = ?, ambiente = ?, tipo = ?, descripcion = ? WHERE id = ?";
            $datos = array(&$this->ip, &$this->nombre, &$this->ambiente, &$this->tipo, &$this->descripcion, &$ipOriginal);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return ($modificacion == 2) ? $this->registrarActividad("MODIFICACION", $this->ip) : $modificacion;
        }
        $this->mensaje = "No se recibieron todos los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->ip) {
            $consulta = "SELECT * FROM ser_servidor WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->ip));
            if (gettype($fila) == "array") {
                $this->ip = $fila['id'];
                $this->nombre = $fila['nombre'];
                $this->ambiente = $fila['ambiente'];
                $this->tipo = $fila['tipo'];
                $this->descripcion = $fila['descripcion'];
                $this->estado = $fila['estado'];
                return 2;
            }
            $this->mensaje = "No se obtuvo la información del servidor";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia al servidor";
        return 0;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("ser_servidor", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
