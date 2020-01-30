<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if (isset($_POST['sigla'])) {
    $controlador = new ControladorInstalacion();
    $sigla = $_POST['sigla'];
    $nombre = $_POST['nombre'];
    $gerencia = $_POST['gerencia'];
    $responsable = $_POST['responsable'];
    $ubicacion = $_POST['ubicacion'];
    $plataforma = $_POST['plataforma'];
    $rti = $_POST['rti'];
    $descripcion = $_POST['descripcion'];
    $creacion = $controlador->crear($sigla, $nombre, $gerencia, $descripcion, $plataforma, $responsable, $ubicacion, $rti);
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
