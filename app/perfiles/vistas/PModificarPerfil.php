<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if (isset($_POST['idPerfil'])) {
    $controlador = new ControladorPerfil();
    $id = $_POST['idPerfil'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $permisos = $_POST['permisos'];
    $modificacion = $controlador->modificar($id, $nombre, $descripcion, $permisos);
    $exito = ($modificacion == 2) ? true : false;
    $mensaje = $controlador->getMensaje();
    $resultado = ControladorHTML::getAlertaOperacion($modificacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
