<?php

/**
 * Description of Permiso
 *
 * @author 07489
 */
class Permiso {

    private $id;
    private $titulo;
    private $nivel;
    private $padre;
    private $link;
    private $mensaje;

    public function __construct($id = NULL, $titulo = NULL, $nivel = NULL, $padre = NULL, $link = NULL) {
        $this->setId($id);
        $this->setTitulo($titulo);
        $this->setNivel($nivel);
        $this->setPadre($padre);
        $this->setLink($link);
    }

    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return utf8_encode($this->titulo);
    }

    public function getNivel() {
        return $this->nivel;
    }

    public function getPadre() {
        return $this->padre;
    }

    public function getLink() {
        return $this->link;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitulo($titulo) {
        $this->titulo = utf8_decode($titulo);
    }

    public function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    public function setPadre($padre) {
        $this->padre = $padre;
    }

    public function setLink($link) {
        $this->link = $link;
    }

    public function borrar() {
        if ($this->id) {
            $consulta = "DELETE FROM seg_permiso WHERE id = ?";
            $eliminacion = SQLServer::instancia()->borrar($consulta, array($this->id));
            $this->mensaje = SQLServer::instancia()->getMensaje();
            if ($eliminacion == 2) {
                $eliminacion = $this->registrarActividad("ELIMINACION", $this->id);
            }
            return $eliminacion;
        }
        $this->mensaje = "No se pudo hacer referencia al permiso";
        return 0;
    }

    public function crear() {
        if ($this->titulo && $this->nivel) {
            $consulta = "INSERT INTO seg_permiso OUTPUT INSERTED.id VALUES (?, ?, ?, ?)";
            $datos = array(&$this->titulo, &$this->nivel, &$this->padre, &$this->link);
            $creacion = SQLServer::instancia()->insertar($consulta, $datos);
            $this->mensaje = utf8_encode($this->titulo) . ": " . SQLServer::instancia()->getMensaje();
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
        if ($this->id && $this->titulo && $this->nivel) {
            $consulta = "UPDATE seg_permiso SET titulo = ?, nivel = ?, padre = ?, link = ? WHERE id = ?";
            $datos = array($this->titulo, $this->nivel, $this->padre, $this->link, $this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->titulo) . ": " . SQLServer::instancia()->getMensaje();
            if ($modificacion == 2) {
                $modificacion = $this->registrarActividad("MODIFICACION", $this->id);
            }
            return $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM seg_permiso WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array($this->id));
            if (gettype($fila) == 'array') {
                $this->titulo = $fila['titulo'];
                $this->nivel = $fila['nivel'];
                $this->padre = $fila['padre'];
                $this->link = $fila['link'];
                return $this->obtenerPadre($fila['nivel'], $fila['padre']);
            }
            $this->mensaje = "No se obtuvo la información del permiso";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia al permiso";
        return 0;
    }

    private function obtenerPadre($nivel, $idPadre) {
        if ($nivel > 1) {
            $padre = new Permiso($idPadre);
            $resultado = $padre->obtener();
            $this->padre = ($resultado == 2) ? $padre : NULL;
            $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener el padre";
            return $resultado;
        }
        return 2;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("seg_permisos", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
