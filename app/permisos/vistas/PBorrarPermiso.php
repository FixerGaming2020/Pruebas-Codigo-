<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

if ($_POST['mcepIdPermiso']) {
    $controlador = new ControladorPermiso();
    $id = $_POST['mcepIdPermiso'];
    $eliminacion = $controlador->borrar($id);
    $mensaje = $controlador->getMensaje();
    $resultado = ControladorHTML::getAlertaOperacion($eliminacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

echo $resultado;