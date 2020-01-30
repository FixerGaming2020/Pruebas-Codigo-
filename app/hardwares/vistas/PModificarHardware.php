<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if (isset($_POST['idHardware'])) {
    $id = $_POST['idHardware'];
    $tipo = $_POST['tipo'];
    $ambiente = $_POST['ambiente'];
    $sigla = $_POST['sigla'];
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['sucursal'];
    $dominio = $_POST['dominio'];
    $swBase = $_POST['swbase'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $arquitectura = $_POST['arquitectura'];
    $core = $_POST['core'];
    $procesador = $_POST['procesador'];
    $mhz = $_POST['mhz'];
    $memoria = $_POST['memoria'];
    $disco = $_POST['disco'];
    $raid = $_POST['raid'];
    $red = $_POST['red'];
    $rti = $_POST['rti'];
    $funcion = $_POST['funcion'];
    $controlador = new ControladorHardware();
    $modificacion = $controlador->modificar($id, $tipo, $sigla, $nombre, $dominio, $swBase, $ambiente, $funcion, $ubicacion, $marca, $modelo, $arquitectura, $core, $procesador, $mhz, $memoria, $disco, $raid, $red, $rti);
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
