<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$arreglo = array();
if (isset($_POST['nombre'])) {
    $controlador = new ControladorLenguaje();
    $nombre = $_POST['nombre'];
    $lenguajes = $controlador->seleccionar($nombre);
    if (gettype($lenguajes) == "resource") {
        while ($lenguaje = sqlsrv_fetch_array($lenguajes, SQLSRV_FETCH_ASSOC)) {
            $texto = utf8_encode($lenguaje["nombre"]) . ' (' . utf8_encode($lenguaje["version"]) . ')';
            $arreglo[] = array('id' => $lenguaje["id"], 'text' => $texto);
        }
    } else {
        $texto = ($lenguajes == 1) ? "Sin resultados" : "Error";
        $arreglo[] = array('id' => "NO", 'text' => $texto);
    }
} else {
    $arreglo[] = array('id' => "NO", 'text' => "Sin parametros");
}

echo json_encode($arreglo);
