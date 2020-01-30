<?php

/**
 * Description of Usuario
 *
 * @author 07489
 */
class Usuario {

    private $id;
    private $nombre;
    private $estado;
    private $perfil;
    private $mensaje;

    public function __construct($id = NULL, $nombre = NULL, $estado = NULL, $perfil = NULL) {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setEstado($estado);
        $this->setPerfil($perfil);
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

    public function getPerfil() {
        return $this->perfil;
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

    public function setPerfil($perfil) {
        $this->perfil = $perfil;
    }

    public function cambiarEstado() {
        if ($this->id && $this->estado) {
            $consulta = "UPDATE seg_usuario SET estado = ? WHERE id = ?";
            $modificacion = SQLServer::instancia()->modificar($consulta, array($this->estado, $this->id));
            $this->mensaje = SQLServer::instancia()->getMensaje();
            if ($modificacion == 2) {
                $operacion = ($this->estado == 1) ? "ALTA" : "BAJA";
                $modificacion = $this->registrarActividad($operacion, $this->id);
            }
            return $modificacion;
        }
        $this->mensaje = "No se pudo hacer referencia al usuario";
        return 0;
    }

    public function crear() {
        if ($this->id && $this->nombre && $this->perfil) {
            $consulta = "INSERT INTO seg_usuario VALUES (?, ?, ?, 'Activo')";
            $datos = array($this->id, $this->nombre, $this->perfil);
            $creacion = SQLServer::instancia()->insertar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            if ($creacion == 2) {
                $creacion = $this->registrarActividad("CREACION", $this->id);
            }
            return $creacion;
        }
        return 0;
    }

    public function modificar($legajoOriginal) {
        if ($this->id && $this->nombre && $this->perfil) {
            $consulta = "UPDATE seg_usuario SET id = ?, nombre = ?, perfil = ? WHERE id = ?";
            $datos = array($this->id, $this->nombre, $this->perfil, $legajoOriginal);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            if ($modificacion == 2) {
                $modificacion = $this->registrarActividad("MODIFICACION", $this->id);
            }
            return $modificacion;
        }
        return 0;
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM seg_usuario WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (gettype($fila) == "array") {
                $this->nombre = $fila['nombre'];
                $this->estado = $fila['estado'];
                return $this->obtenerPerfil($fila['perfil']);
            }
            $this->mensaje = "No se obtuvo la información del usuario";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia al usuario";
        return 0;
    }

    private function obtenerPerfil($idPerfil) {
        $perfil = new Perfil($idPerfil);
        $resultado = $perfil->obtener();
        $this->perfil = ($resultado == 2) ? $perfil : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener el perfil";
        return $resultado;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("seg_usuario", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
