<?php

/**
 * Description of Responsable
 *
 * @author Emanuel
 */
class Responsable {

    private $id;
    private $nombre;
    private $telefono;
    private $correo;
    private $proveedor;
    private $estado;
    private $mensaje;

    public function __construct($id = NULL, $nombre = NULL, $telefono = NULL, $correo = NULL, $proveedor = NULL, $estado = NULL) {
        $this->id = $id;
        $this->nombre = utf8_decode($nombre);
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->proveedor = $proveedor;
        $this->estado = $estado;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return utf8_encode($this->nombre);
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getProveedor() {
        return $this->proveedor;
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

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function setProveedor($proveedor) {
        $this->proveedor = $proveedor;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function cambiarEstado() {
        if ($this->id && $this->estado) {
            $consulta = "UPDATE pro_responsable SET estado = ? WHERE id = ?";
            $modificacion = SQLServer::instancia()->modificar($consulta, array(&$this->estado, &$this->id));
            $this->mensaje = SQLServer::instancia()->getMensaje();
            if ($modificacion == 2) {
                $operacion = ($this->estado == 'Activo') ? "ALTA" : "BAJA";
                $modificacion = $this->registrarActividad($operacion, $this->id);
            }
            return $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 1;
    }

    public function crear() {
        if ($this->nombre && $this->correo && $this->proveedor) {
            $consulta = "INSERT INTO pro_responsable OUTPUT INSERTED.id VALUES (?, ?, ?, ?, 'Activo')";
            $datos = array(&$this->nombre, &$this->telefono, &$this->correo, &$this->proveedor);
            $creacion = SQLServer::instancia()->insertar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            if ($creacion == 2) {
                $this->id = SQLServer::instancia()->getUltimoId();
                $creacion = $this->registrarActividad("CREACION", $this->id);
            }
            return $creacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 1;
    }

    public function modificar() {
        if ($this->id && $this->nombre && $this->telefono && $this->correo && $this->proveedor) {
            $consulta = "UPDATE pro_responsable SET nombre = ?, telefono = ?, correo = ?, proveedor = ? WHERE id = ?";
            $datos = array(&$this->nombre, &$this->telefono, &$this->correo, &$this->proveedor, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return ($modificacion == 2) ? $this->registrarActividad("MODIFICACION", $this->id) : $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM pro_responsable WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (!is_null($fila)) {
                $this->nombre = $fila['nombre'];
                $this->telefono = $fila['telefono'];
                $this->correo = $fila['correo'];
                $obtenerProveedor = $this->obtenerProveedor($fila['proveedor']);
                return $obtenerProveedor;
            }
            $this->mensaje = "No se obtuvo la información del responsable";
            return 1;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    private function obtenerProveedor($idProveedor) {
        $proveedor = new Proveedor($idProveedor);
        $resultado = $proveedor->obtener();
        $this->proveedor = ($resultado == 2) ? $proveedor : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener el proveedor";
        return $resultado;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("pro_responsable", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
