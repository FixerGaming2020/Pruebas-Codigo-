<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$arreglo = array();
if ($_POST['nombre']) {
    $controlador = new ControladorEmpleado();
    $nombre = $_POST['nombre'];
    $empleados = $controlador->seleccionar($nombre);
    if (gettype($empleados) == "resource") {
        while ($empleado = sqlsrv_fetch_array($empleados, SQLSRV_FETCH_ASSOC)) {
            $arreglo[] = array('id' => $empleado["eid"], 'text' => utf8_encode($empleado["enombre"]));
        }
    } else {
        $texto = ($empleados == 1) ? "Sin resultados" : "Error";
        $arreglo[] = array('id' => "NO", 'text' => $texto);
    }
} else {
    $arreglo[] = array('id' => "NO", 'text' => "Sin parametros");
}

echo json_encode($arreglo);
