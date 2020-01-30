<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if (isset($_POST['idDepartamento'])) {
    $id = $_POST['idDepartamento'];
    $nombre = $_POST['nombre'];
    $gerencia = $_POST['gerencia'];
    $controlador = new ControladorDepartamento();
    $modificacion = $controlador->modificar($id, $nombre, $gerencia);
    $mensaje = $controlador->getMensaje();
    $resultado = ControladorHTML::getAlertaOperacion($modificacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
