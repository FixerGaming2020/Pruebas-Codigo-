<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if ($_POST['idAplicacion']) {
    $controlador = new ControladorAplicacion();
    $id = $_POST['idAplicacion'];
    $nombre = $_POST['nombre'];
    $servidorProduccion = (!isset($_POST['sproduccion']) || $_POST['sproduccion'] == 'NO') ? NULL : $_POST['sproduccion'];
    $puertoProduccion = ($_POST['pproduccion']) ? $_POST['pproduccion'] : NULL;
    $servidorTest = (!isset($_POST['stest']) || $_POST['stest'] == 'NO') ? NULL : $_POST['stest'];
    $puertoTest = ($_POST['ptest']) ? $_POST['ptest'] : NULL;
    $modificacion = $controlador->modificarSP($id, $nombre, $servidorProduccion, $puertoProduccion, $servidorTest, $puertoTest);
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
