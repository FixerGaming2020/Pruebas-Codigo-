<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$arreglo = array();
if (isset($_POST['nombre'])) {
    $controlador = new ControladorModoProcesamiento();
    $nombre = $_POST['nombre'];
    $modos = $controlador->seleccionar($nombre);
    if (gettype($modos) == "resource") {
        while ($modo = sqlsrv_fetch_array($modos, SQLSRV_FETCH_ASSOC)) {
            $arreglo[] = array('id' => $modo["id"], 'text' => utf8_encode($modo["nombre"]));
        }
    } else {
        $texto = ($modos == 1) ? "Sin resultados" : "Error";
        $arreglo[] = array('id' => "NO", 'text' => $texto);
    }
} else {
    $arreglo[] = array('id' => "NO", 'text' => "Sin parametros");
}

echo json_encode($arreglo);