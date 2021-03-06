<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if ($_POST['nombre'] && $_POST['version'] && $_POST['fabricante'] && $_POST['descripcion']) {
    $controlador = new ControladorHerramientaDesarrollo();
    $nombre = $_POST['nombre'];
    $version = $_POST['version'];
    $fabricante = $_POST['fabricante'];
    $descripcion = $_POST['descripcion'];
    $creacion = $controlador->crear($nombre, $version, $fabricante, $descripcion);
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
