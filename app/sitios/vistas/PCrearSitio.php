<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if (isset($_POST['codigo'])) {
    $codigo = $_POST['codigo'];
    $tipo = $_POST['tipo'];
    $nombre = $_POST['nombre'];
    $provincia = $_POST['provincia'];
    $localidad = $_POST['localidad'];
    $codigoPostal = $_POST['codigoPostal'];
    $direccion = $_POST['direccion'];
    $origen = $_POST['origen'];
    $controlador = new ControladorSitio();
    $creacion = $controlador->crear($codigo, $tipo, $nombre, $provincia, $localidad, $codigoPostal, $direccion, $origen);
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


