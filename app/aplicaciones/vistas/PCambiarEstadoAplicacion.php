<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

if (isset($_POST['mceaAccion'])) {
    $controlador = new ControladorAplicacion();
    $id = $_POST['mceaIdAplicacion'];
    $estado = ($_POST['mceaAccion'] == "ALTA") ? 'Activa' : 'Inactiva';
    $modificacion = $controlador->cambiarEstado($id, $estado);
    $mensaje = $controlador->getMensaje();
    $resultado = ControladorHTML::getAlertaOperacion($modificacion, $mensaje);
} else {
    $mensaje = "No se recibió la información desde el formulario";
    $resultado = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

echo $resultado;


