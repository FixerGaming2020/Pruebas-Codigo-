<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if (isset($_POST['idInstalacion'])) {
    $controlador = new ControladorInstalacion();
    $id = $_POST['idInstalacion'];
    $sigla = $_POST['sigla'];
    $nombre = $_POST['nombre'];
    $gerencia = $_POST['gerencia'];
    $responsable = $_POST['responsable'];
    $ubicacion = $_POST['ubicacion'];
    $plataforma = $_POST['plataforma'];
    $rti = $_POST['rti'];
    $descripcion = $_POST['descripcion'];
    $modificacion = $controlador->modificar($id, $sigla, $nombre, $gerencia, $descripcion, $plataforma, $responsable, $ubicacion, $rti);
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

