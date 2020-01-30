<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$arreglo = array();
if (isset($_POST['nombre'])) {
    $controlador = new ControladorBase();
    $nombre = $_POST['nombre'];
    $bases = $controlador->seleccionar($nombre);
    if (gettype($bases) == "resource") {
        while ($base = sqlsrv_fetch_array($bases, SQLSRV_FETCH_ASSOC)) {
            $arreglo[] = array('id' => $base["bid"], 'text' => utf8_encode($base["bnombre"]));
        }
    } else {
        $texto = ($bases == 1) ? "Sin resultados" : "Error";
        $arreglo[] = array('id' => "NO", 'text' => $texto);
    }
} else {
    $arreglo[] = array('id' => "NO", 'text' => "Sin parametros");
}

echo json_encode($arreglo);


