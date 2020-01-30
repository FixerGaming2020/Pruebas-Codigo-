<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if ($_POST['idAplicacion']) {
    $controlador = new ControladorAplicacion();
    $id = $_POST['idAplicacion'];
    $nombre = $_POST['nombre'];
    $confidencialidad = $_POST['confidencialidad'];
    $integridad = $_POST['integridad'];
    $disponibilidad = $_POST['disponibilidad'];
    $criticidad = $_POST['criticidad'];
    $modificacion = $controlador->modificarTP($id, $nombre, $confidencialidad, $integridad, $disponibilidad, $criticidad);
    $mensaje = $controlador->getMensaje();
    $exito = ($modificacion == 2) ? true : false;
    $resultado = ControladorHTML::getAlertaOperacion($modificacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
