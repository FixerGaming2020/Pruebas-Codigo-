<?php

/**
 * Description of ControladorFirewall
 *
 * @author Emanuel
 */
class ControladorFirewall {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $resultado = Firewalls::buscar($nombre, $estado);
        $this->mensaje = Firewalls::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $firewall = new Firewall($id, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $estado);
            $modificacion = $firewall->cambiarEstado();
            $this->mensaje = $firewall->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function crear($nombre, $marca, $modelo, $nroSerie, $version, $sucursal, $ip) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $firewall = new Firewall(NULL, $nombre, $marca, $modelo, $nroSerie, $version, $sucursal, $ip);
            $creacion = $firewall->crear();
            $this->mensaje = $firewall->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function consultar($nombre, $marca, $ip, $sitio) {
        $resultado = Firewalls::consultar($nombre, $marca, $ip, $sitio);
        $this->mensaje = Firewalls::getMensaje();
        return $resultado;
    }

    public function listarUltimosCreados() {
        $resultado = Firewalls::listarUltimosCreados();
        $this->mensaje = Firewalls::getMensaje();
        return $resultado;
    }

    public function modificar($id, $nombre, $marca, $modelo, $nroSerie, $version, $sucursal, $ip) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $firewall = new Firewall($id, $nombre, $marca, $modelo, $nroSerie, $version, $sucursal, $ip);
            $modificacion = $firewall->modificar();
            $this->mensaje = $firewall->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

}
