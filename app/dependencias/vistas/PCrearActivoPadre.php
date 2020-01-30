<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if ($_POST['sigla'] && $_POST['nombre'] && $_POST['hijos']) {
    $controlador = new ControladorActivoPadre();
    $categoria = $_POST['categoria'];
    $sigla = $_POST['sigla'];
    $nombre = $_POST['nombre'];
    $hijos = $_POST['hijos'];
    $creacion = $controlador->crear($categoria, $sigla, $nombre, $hijos);
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
