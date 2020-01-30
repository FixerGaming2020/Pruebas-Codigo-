<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if ($_POST['sigla'] && $_POST['nombre']) {
    $controlador = new ControladorAplicacion();
    $sigla = $_POST['sigla'];
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $seguridad = $_POST['seguridad'];
    $tecnologia = $_POST['tecnologia'];
    $proveedor = (!isset($_POST['proveedor']) || $_POST['proveedor'] == 'NO') ? NULL : $_POST['proveedor'];
    $lenguaje = (!isset($_POST['lenguaje']) || $_POST['lenguaje'] == 'NO') ? NULL : $_POST['lenguaje'];
    $herramienta = (!isset($_POST['herramienta']) || $_POST['herramienta'] == 'NO') ? NULL : $_POST['herramienta'];
    $base = (!isset($_POST['base']) || $_POST['base'] == "NO") ? NULL : $_POST['base'];
    $modo = $_POST['modo'];
    $lugar = $_POST['lugar'];
    $plataforma = $_POST['plataforma'];
    $empleado = (!isset($_POST['delegado']) || $_POST['delegado'] == 'NO') ? NULL : $_POST['delegado'];
    $sDesarrollo = (!isset($_POST['sdesarrollo']) || $_POST['sdesarrollo'] == 'NO') ? NULL : $_POST['sdesarrollo'];
    $pDesarrollo = ($_POST['pdesarrollo']) ? $_POST['pdesarrollo'] : NULL;
    $rti = $_POST['rti'];
    $descripcion = $_POST['descripcion'];
    $creacion = $controlador->crear($sigla, $nombre, $tipo, $seguridad, $tecnologia, $proveedor, $lenguaje, $herramienta, $base, $modo, $lugar, $plataforma, $empleado, $sDesarrollo, $pDesarrollo, $rti, $descripcion);
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
