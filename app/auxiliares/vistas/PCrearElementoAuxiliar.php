<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if ($_POST['nombre'] && $_POST['gerencia'] && $_POST['delegado'] && $_POST['ubicacion']) {
    $controlador = new ControladorAuxiliar();
    $sigla = $_POST['sigla'];
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $gerencia = $_POST['gerencia'];
    $delegado = $_POST['delegado'];
    $sitio = $_POST['ubicacion'];
    $rti = $_POST['rti'];
    $descripcion = $_POST['descripcion'];
    $creacion = $controlador->crear($sigla, $nombre, $gerencia, $delegado, $sitio, $cantidad, $descripcion, $rti);
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
