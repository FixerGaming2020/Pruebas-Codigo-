<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if (isset($_POST['idActivoPadre'])) {
    $id = $_POST['idActivoPadre'];
    $categoria = $_POST['categoria'];
    $sigla = $_POST['sigla'];
    $nombre = $_POST['nombre'];
    $hijos = $_POST['hijos'];
    $controlador = new ControladorActivoPadre();
    $modificacion = $controlador->modificar($id, $categoria, $sigla, $nombre, $hijos);
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
