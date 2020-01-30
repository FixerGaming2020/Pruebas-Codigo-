<?php

/**
 * Description of ControladorVista
 *
 * @author Emanuel
 */
class ControladorFormulario {

    private $vistas;

    public function __construct() {
        
    }

    public function evaluarVista($link) {
        if (isset($_SESSION['vistas'])) {
            $archivo = NULL;
            $vistas = $_SESSION['vistas'];
            for ($index = 0; $index < count($vistas); $index++) {
                if ($vistas[$index][1] == $link) {
                    $archivo = $vistas[$index][0];
                    break;
                }
            }
            if ($archivo) {
                $particion = explode("_", $link);
                $modulo = $particion[0];
                $this->cargarVista($modulo, $archivo);
            } else {
                $this->cargarVista("principal", "error");
            }
        } else {
            $this->cargarVista("principal", "error");
        }
    }

    public function cargarVista($modulo, $vista) {
        require_once ("app/principal/modelos/Constantes.php");
        require_once ("app/principal/vistas/header.php");
        require_once ("app/{$modulo}/vistas/{$vista}.php");
    }

    public function cargarLogin() {
        require_once ("app/principal/vistas/formLogin.php");
    }

}
