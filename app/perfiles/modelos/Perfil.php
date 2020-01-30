<?php

/**
 * Description of Perfil
 *
 * @author 07489
 */
class Perfil {

    private $id;
    private $nombre;
    private $descripcion;
    private $estado;
    private $permisos;
    private $mensaje;

    public function __construct($id = NULL, $nombre = NULL, $descripcion = NULL, $estado = NULL, $permisos = NULL) {
        $this->id = $id;
        $this->nombre = utf8_decode($nombre);
        $this->descripcion = utf8_decode($descripcion);
        $this->estado = $estado;
        $this->permisos = $permisos;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return utf8_encode($this->nombre);
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

    public function getPermisos() {
        return $this->permisos;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = utf8_decode($nombre);
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = utf8_decode($descripcion);
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setPermisos($permisos) {
        $this->permisos = $permisos;
    }

    public function cambiarEstado() {
        if ($this->id && $this->estado) {
            $consulta = "UPDATE seg_perfil SET estado = ? WHERE id = ?";
            $modificacion = SQLServer::instancia()->modificar($consulta, array($this->estado, $this->id));
            $this->mensaje = SQLServer::instancia()->getMensaje();
            if ($modificacion == 2) {
                $operacion = ($this->estado == 1) ? "ALTA" : "BAJA";
                $modificacion = $this->registrarActividad($operacion, $this->id);
            }
            return $modificacion;
        }
        $this->mensaje = "No se pudo hacer referencia al perfil";
        return 0;
    }

    public function crear() {
        if ($this->nombre && $this->descripcion && $this->permisos) {
            $consulta = "INSERT INTO seg_perfil OUTPUT INSERTED.id VALUES (?, ?, 'Activo')";
            $datos = array(&$this->nombre, &$this->descripcion);
            $creacion = SQLServer::instancia()->insertar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            if ($creacion == 2) {
                $this->id = SQLServer::instancia()->getUltimoId();
                $creaRelacion = PerfilPermiso::crear($this->id, $this->permisos);
                $this->mensaje = ($creaRelacion == 2) ? $this->mensaje : PerfilPermiso::getMensaje();
                return ($creaRelacion == 2) ? $this->registrarActividad("CREACION", $this->id) : $creaRelacion;
            }
            return $creacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function modificar() {
        if ($this->id && $this->nombre && $this->descripcion && $this->permisos) {
            $consulta = "UPDATE seg_perfil SET nombre = ?, descripcion = ? WHERE id = ?";
            $datos = array(&$this->nombre, &$this->descripcion, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            if ($modificacion == 2) {
                $sborrar = PerfilPermiso::borrar($this->id);
                $this->mensaje = ($sborrar == 2) ? $this->mensaje : "Permisos: " . PerfilPermiso::getMensaje();
                $screar = PerfilPermiso::crear($this->id, $this->permisos);
                $this->mensaje = ($screar == 2) ? $this->mensaje : "Permisos: " . PerfilPermiso::getMensaje();
                return ($sborrar == 2 && $screar == 2) ? $this->registrarActividad("MODIFICACION", $this->id) : 1;
            }
            return $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM seg_perfil WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (gettype($fila) == "array") {
                $this->nombre = $fila['nombre'];
                $this->descripcion = $fila['descripcion'];
                $this->permisos = $this->obtenerPermisos();
                return 2;
            }
            $this->mensaje = "No se obtuvo la información del perfil";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia al perfil";
        return 0;
    }

    private function obtenerPermisos() {
        $permisos = new Permisos();
        $resultado = $permisos->listarMenu($this->id);
        $arregloMenu = array();
        if (gettype($resultado) == "resource") {
            while ($menu = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $resultadoSM = $permisos->listarSubMenu($this->id, $menu['id']);
                $arregloSubmenu = array();
                if (gettype($resultadoSM) == 'resource') {
                    while ($submenu = sqlsrv_fetch_array($resultadoSM, SQLSRV_FETCH_ASSOC)) {
                        $arregloSubmenu[] = array($submenu['id'], $submenu['titulo'], $submenu['link']);
                    }
                    $arregloMenu[] = array($menu['id'], $menu['titulo'], $arregloSubmenu);
                }
            }
        }
        return $arregloMenu;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("seg_perfil", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
