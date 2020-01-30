<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$arreglo = array();
if (isset($_POST['nombre'])) {
    $controlador = new ControladorLugarProcesamiento();
    $nombre = $_POST['nombre'];
    $lugares = $controlador->seleccionar($nombre);
    if (gettype($lugares) == "resource") {
        while ($lugar = sqlsrv_fetch_array($lugares, SQLSRV_FETCH_ASSOC)) {
            $arreglo[] = array('id' => $lugar["id"], 'text' => utf8_encode($lugar["nombre"]));
        }
    } else {
        $texto = ($lugares == 1) ? "Sin resultados" : "Error";
        $arreglo[] = array('id' => "NO", 'text' => $texto);
    }
} else {
    $arreglo[] = array('id' => "NO", 'text' => "Sin parametros");
}

echo json_encode($arreglo);

