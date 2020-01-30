<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if ($_POST['nombre'] && $_POST['instalacion'] && $_POST['sitio']) {
    $controlador = new ControladorSwitch();
    $nombre = $_POST['nombre'];
    $modelo = $_POST['modelo'];
    $version = $_POST['version'];
    $instalacion = $_POST['instalacion'];
    $sitio = $_POST['sitio'];
    $rti = $_POST['rti'];
    $creacion = $controlador->crear($nombre, $modelo, $version, $sitio, $instalacion, $rti);
    $mensaje = $controlador->getMensaje();
    $exito = ($creacion == 2) ? true : false;
    $resultado = ControladorHTML::getAlertaOperacion($creacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
