<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

if (isset($_POST['mceuAccion'])) {
    $controlador = new ControladorUsuario();
    $id = $_POST['mceuIdUsuario'];
    $estado = ($_POST['mceuAccion'] == "ALTA") ? 'Activo' : 'Inactivo';
    $modificacion = $controlador->cambiarEstado($id, $estado);
    $mensaje = $controlador->getMensaje();
    $resultado = ControladorHTML::getAlertaOperacion($modificacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

echo $resultado;
