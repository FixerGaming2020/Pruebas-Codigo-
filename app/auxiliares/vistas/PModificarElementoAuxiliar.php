<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if (isset($_POST['idAuxiliar'])) {
    $controlador = new ControladorAuxiliar();
    $id = $_POST['idAuxiliar'];
    $sigla = $_POST['sigla'];
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $gerencia = $_POST['gerencia'];
    $delegado = $_POST['delegado'];
    $sitio = $_POST['ubicacion'];
    $rti = $_POST['rti'];
    $descripcion = $_POST['descripcion'];
    $modificacion = $controlador->modificar($id, $sigla, $nombre, $gerencia, $delegado, $sitio, $cantidad, $descripcion, $rti);
    $mensaje = $controlador->getMensaje();
    $exito = ($modificacion == 2) ? true : false;
    $resultado = ControladorHTML::getAlertaOperacion($modificacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
