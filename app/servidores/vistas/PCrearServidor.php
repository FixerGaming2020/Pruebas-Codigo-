<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $ip = $_POST['ip'];
    $ambiente = $_POST['ambiente'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $controlador = new ControladorServidor();
    $creacion = $controlador->crear($nombre, $ip, $ambiente, $tipo, $descripcion);
    $mensaje = $controlador->getMensaje();
    $exito = ($creacion == 2) ? TRUE : FALSE;
    $resultado = ControladorHTML::getAlertaOperacion($creacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
