<?php

/**
 * Description of Proveedor
 *
 * @author Emanuel
 */
class Proveedor {

    private $id;
    private $nombre;
    private $telefono;
    private $correo;
    private $provincia;
    private $localidad;
    private $direccion;
    private $tipo;
    private $servicios;
    private $estado;
    private $mensaje;

    public function __construct($id = NULL, $nombre = NULL, $telefono = NULL, $correo = NULL, $provincia = NULL, $localidad = NULL, $direccion = NULL, $tipo = NULL, $servicios = NULL, $estado = NULL) {
        $this->id = $id;
        $this->nombre = utf8_decode($nombre);
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->provincia = utf8_decode($provincia);
        $this->localidad = utf8_decode($localidad);
        $this->direccion = utf8_decode($direccion);
        $this->tipo = utf8_decode($tipo);
        $this->servicios = $servicios;
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

    public function getProvincia() {
        return utf8_encode($this->provincia);
    }

    public function getLocalidad() {
        return utf8_encode($this->localidad);
    }

    public function getDireccion() {
        return utf8_encode($this->direccion);
    }

    public function getTipo() {
        return utf8_encode($this->tipo);
    }

    public function getServicios() {
        return $this->servicios;
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

    public function setProvincia($provincia) {
        $this->provincia = utf8_decode($provincia);
    }

    public function setLocalidad($localidad) {
        $this->localidad = utf8_decode($localidad);
    }

    public function setDireccion($direccion) {
        $this->direccion = utf8_decode($direccion);
    }

    public function setTipo($tipo) {
        $this->tipo = utf8_decode($tipo);
    }

    public function setServicios($servicios) {
        $this->servicios = $servicios;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function cambiarEstado() {
        if ($this->id && $this->estado) {
            $consulta = "UPDATE pro_proveedor SET estado = ? WHERE id = ?";
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
        if ($this->nombre && $this->provincia && $this->localidad && $this->direccion && $this->servicios) {
            $consulta = "INSERT INTO pro_proveedor OUTPUT INSERTED.id VALUES (?, ?, ?, ?, ?, ?, ?, 'Activo')";
            $datos = array(&$this->nombre, &$this->telefono, &$this->correo, &$this->provincia, &$this->localidad, &$this->direccion, &$this->tipo);
            $creacion = SQLServer::instancia()->insertar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            if ($creacion == 2) {
                $this->id = SQLServer::instancia()->getUltimoId();
                $rservicios = ProveedorServicio::crear($this->id, $this->servicios);
                $this->mensaje = ($rservicios == 2) ? $this->mensaje : ProveedorServicio::getMensaje();
                return ($rservicios == 2) ? $this->registrarActividad("CREACION", $this->id) : $rservicios;
            }
            return $creacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function modificar() {
        if ($this->id && $this->nombre && $this->provincia && $this->localidad && $this->direccion && $this->servicios) {
            $consulta = "UPDATE pro_proveedor SET nombre=?, telefono=?, correo=?, provincia=?, ciudad=?, direccion=?, tipo=? WHERE id = ?";
            $datos = array(&$this->nombre, &$this->telefono, &$this->correo, &$this->provincia, &$this->localidad, &$this->direccion, &$this->tipo, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            if ($modificacion == 2) {
                $sborrar = ProveedorServicio::borrar($this->id);
                $this->mensaje = ($sborrar == 2) ? $this->mensaje : ProveedorServicio::getMensaje();
                $screar = ProveedorServicio::crear($this->id, $this->servicios);
                $this->mensaje = ($screar == 2) ? $this->mensaje : ProveedorServicio::getMensaje();
                return ($sborrar == 2 && $screar == 2) ? $this->registrarActividad("MODIFICACION", $this->id) : 1;
            }
            return $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM pro_proveedor WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (gettype($fila) == "array") {
                $this->nombre = $fila['nombre'];
                $this->telefono = $fila['telefono'];
                $this->correo = $fila['correo'];
                $this->provincia = $fila['provincia'];
                $this->localidad = $fila['ciudad'];
                $this->direccion = $fila['direccion'];
                $this->tipo = $fila['tipo'];
                return $this->obtenerServicios();
            }
            $this->mensaje = "No se obtuvo la información del proveedor";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia al proveedor";
        return 0;
    }

    private function obtenerServicios() {
        $servicios = Servicios::listarServiciosProveedor($this->id);
        if (gettype($servicios) == "resource") {
            $this->servicios = array();
            while ($servicio = sqlsrv_fetch_array($servicios, SQLSRV_FETCH_ASSOC)) {
                $this->servicios[] = array("id" => $servicio['id'], "nombre" => utf8_encode($servicio['nombre']));
            }
            return 2;
        }
        $this->mensaje = "Servicios del proveedor: " . Servicios::getMensaje();
        return 1;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("pro_proveedor", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
