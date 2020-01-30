<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

if ($_POST['mcehAccion'] && isset($_POST['mcehIdHerramienta'])) {
    $controlador = new ControladorHerramientaDesarrollo();
    $id = $_POST['mcehIdHerramienta'];
    $estado = ($_POST['mcehAccion'] == "ALTA") ? 'Activa' : 'Inactiva';
    $modificacion = $controlador->cambiarEstado($id, $estado);
    $mensaje = $controlador->getMensaje();
    $resultado = ControladorHTML::getAlertaOperacion($modificacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

echo $resultado;
