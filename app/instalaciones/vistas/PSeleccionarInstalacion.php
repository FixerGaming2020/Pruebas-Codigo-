<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$arreglo = array();
if (isset($_POST['nombre'])) {
    $controlador = new ControladorInstalacion();
    $nombre = $_POST['nombre'];
    $instalaciones = $controlador->seleccionar($nombre);
    if (gettype($instalaciones) == "resource") {
        while ($instalacion = sqlsrv_fetch_array($instalaciones, SQLSRV_FETCH_ASSOC)) {
            $arreglo[] = array('id' => $instalacion["iid"], 'text' => utf8_encode($instalacion["inombre"]));
        }
    } else {
        $texto = ($instalaciones == 1) ? "Sin resultados" : "Error";
        $arreglo[] = array('id' => "NO", 'text' => $texto);
    }
} else {
    $arreglo[] = array('id' => "NO", 'text' => "Sin parametros");
}

echo json_encode($arreglo);
