<?php

/**
 * Description of Gerencia
 *
 * @author Emanuel
 */
class Gerencia {

    private $id;
    private $nombre;
    private $jefe;
    private $estado;
    private $mensaje;

    public function __construct($id = NULL, $nombre = NULL, $jefe = NULL, $estado = NULL) {
        $this->id = $id;
        $this->nombre = utf8_decode($nombre);
        $this->jefe = $jefe;
        $this->estado = $estado;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return utf8_encode($this->nombre);
    }

    public function getJefe() {
        return $this->jefe;
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

    public function setJefe($jefe) {
        $this->jefe = $jefe;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function cambiarEstado() {
        if ($this->id && $this->estado) {
            $consulta = "UPDATE ger_gerencia SET estado = ? WHERE id = ?";
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
        if ($this->nombre) {
            $consulta = "INSERT INTO ger_gerencia OUTPUT INSERTED.id VALUES (?, ?, 'Activa')";
            $datos = array(&$this->nombre, &$this->jefe);
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
        if ($this->id && $this->nombre && $this->jefe) {
            $consulta = "UPDATE ger_gerencia SET nombre=?, empleado=? WHERE id=?";
            $datos = array(&$this->nombre, &$this->jefe, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return ($modificacion == 2) ? $this->registrarActividad("MODIFICACION", $this->id) : $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM ger_gerencia WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (gettype($fila) == "array") {
                $this->nombre = $fila['nombre'];
                $this->estado = $fila['estado'];
                return (isset($fila['empleado'])) ? $this->obtenerJefe($fila['empleado']) : 2;
            }
            $this->mensaje = "No se obtuvo la información de la gerencia";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia a la gerencia";
        return 0;
    }

    private function obtenerJefe($idEmpleado) {
        $jefe = new Empleado($idEmpleado);
        $resultado = $jefe->obtener(TRUE);
        $this->jefe = ($resultado == 2) ? $jefe : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener al jefe";
        return $resultado;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("ger_gerencia", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
