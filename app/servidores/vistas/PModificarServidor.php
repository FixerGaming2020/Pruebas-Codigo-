<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if (isset($_POST['idServidor'])) {
    $controlador = new ControladorServidor();
    $id = $_POST['idServidor'];
    $nombre = $_POST['nombre'];
    $ip = $_POST['ip'];
    $ambiente = $_POST['ambiente'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $modificacion = $controlador->modificar($id, $ip, $nombre, $ambiente, $tipo, $descripcion);
    $mensaje = $controlador->getMensaje();
    $exito = ($modificacion == 2) ? TRUE : FALSE;
    $resultado = ControladorHTML::getAlertaOperacion($modificacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = "<div class='alert alert-danger text-center' role='alert'><i class='fas fa-exclamation-circle'></i> <strong>{$mensaje}</strong></div>";
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
