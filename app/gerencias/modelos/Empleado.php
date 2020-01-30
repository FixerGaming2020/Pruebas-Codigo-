<?php

/**
 * Description of Persona
 *
 * @author Emanuel
 */
class Empleado {

    private $id;
    private $nombre;
    private $departamento;
    private $estado;
    private $mensaje;

    public function __construct($id = NULL, $nombre = NULL, $departamento = NULL, $estado = NULL) {
        $this->id = $id;
        $this->nombre = utf8_decode($nombre);
        $this->departamento = $departamento;
        $this->estado = $estado;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return utf8_encode($this->nombre);
    }

    public function getDepartamento() {
        return $this->departamento;
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

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function cambiarEstado() {
        if ($this->id && $this->estado) {
            $consulta = "UPDATE ger_empleado SET estado = ? WHERE id = ?";
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
        if ($this->id && $this->nombre) {
            $consulta = "INSERT INTO ger_empleado VALUES (?, ?, ?, 'Activo')";
            $datos = array(&$this->id, &$this->nombre, &$this->departamento);
            $creacion = SQLServer::instancia()->insertar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return ($creacion == 2) ? $this->registrarActividad("CREACION", $this->id) : $creacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function modificar($legajo) {
        if ($this->id && $this->nombre && $legajo) {
            $consulta = "UPDATE ger_empleado SET id=?, nombre=?, departamento=? WHERE id=?";
            $datos = array(&$legajo, &$this->nombre, &$this->departamento, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return ($modificacion == 2) ? $modificacion : $this->registrarActividad("MODIFICACION", $this->id);
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function obtener($propios = TRUE) {
        if (!$this->id) {
            $this->mensaje = "No se pudo hacer referencia a la persona";
            return 0;
        }
        $consulta = "SELECT * FROM ger_empleado WHERE id = ?";
        $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
        if (gettype($fila) == "array") {
            $this->nombre = $fila['nombre'];
            $this->estado = $fila['estado'];
            if ($propios) {
                $this->departamento = $fila['departamento'];
                return 2;
            }
            return $this->obtenerDepartamento($fila['departamento']);
        }
        $this->mensaje = "No se obtuvo la información del empleado";
        return 1;
    }

    private function obtenerDepartamento($id) {
        $departamento = new Departamento($id);
        $resultado = $departamento->obtener();
        $this->departamento = ($resultado == 2) ? $departamento : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener el departamento";
        return $resultado;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("ger_empleado", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
