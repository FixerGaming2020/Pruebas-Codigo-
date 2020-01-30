<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if (isset($_POST['idEmpleado'])) {
    $id = $_POST['idEmpleado'];
    $legajo = $_POST['legajo'];
    $nombre = $_POST['nombre'];
    $departamento = (!isset($_POST['departamento']) || $_POST['departamento'] == 'NO') ? NULL : $_POST['departamento'];
    $controlador = new ControladorEmpleado();
    $modificacion = $controlador->modificar($id, $nombre, $departamento, $legajo);
    $mensaje = $controlador->getMensaje();
    $resultado = ControladorHTML::getAlertaOperacion($modificacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
