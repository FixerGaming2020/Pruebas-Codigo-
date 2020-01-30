<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if ($_POST['idServicio'] && $_POST['sigla'] && $_POST['nombre']) {
    $controlador = new ControladorServicio();
    $id = $_POST['idServicio'];
    $sigla = $_POST['sigla'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $modificacion = $controlador->modificar($id, $sigla, $nombre, $descripcion);
    $mensaje = $controlador->getMensaje();
    $exito = ($modificacion == 2) ? TRUE : FALSE;
    $resultado = ControladorHTML::getAlertaOperacion($modificacion, $mensaje);
    Log::escribirLineaError(" mod " . $modificacion . " Men " . $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);

Log::escribirLineaError(" mod " . $json[0]['resultado']);
echo json_encode($json);
