<?php

/**
 * Description of Permisos
 *
 * @author Emanuel
 */
class Permisos {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $nivel) {
        $consulta = "SELECT * FROM vwseg_permiso WHERE titulo LIKE ? AND nivel = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', &$nivel));
        $this->mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public function listar() {
        $consulta = "SELECT * FROM vwseg_permiso ORDER BY nivel, padre, titulo";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        $this->mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    /**
     * Lo usa perfil
     */
    public function listarMenu($idPerfil) {
        $consulta = "SELECT id, titulo FROM seg_permiso PER INNER JOIN seg_perfil_permiso "
                . "REL ON REL.idPermiso = PER.id AND REL.idPerfil = ? "
                . "WHERE PER.nivel = 1 ORDER BY titulo";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$idPerfil));
        $this->mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public function listarSubMenu($idPerfil, $idPadre) {
        $consulta = "SELECT id, titulo, link FROM seg_permiso PER INNER JOIN seg_perfil_permiso "
                . "REL ON REL.idPermiso = PER.id AND REL.idPerfil = ? "
                . "WHERE PER.nivel = 2 AND padre = ? ORDER BY titulo";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$idPerfil, &$idPadre));
        $this->mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public function listarUltimosCreados() {
        $consulta = "SELECT TOP(10) * FROM vwseg_permiso ORDER BY id DESC";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        $this->mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public function selecccionar($nombre, $nivel) {
        $consulta = "SELECT id, titulo FROM vwseg_permiso WHERE titulo LIKE ? AND nivel = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', $nivel));
        $this->mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
