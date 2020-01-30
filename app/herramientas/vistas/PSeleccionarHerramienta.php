<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$arreglo = array();
if (isset($_POST['nombre'])) {
    $controlador = new ControladorHerramientaDesarrollo();
    $nombre = $_POST['nombre'];
    $herramientas = $controlador->seleccionar($nombre);
    if (gettype($herramientas) == "resource") {
        while ($herramienta = sqlsrv_fetch_array($herramientas, SQLSRV_FETCH_ASSOC)) {
            $texto = utf8_encode($herramienta["nombre"]) . " (" . utf8_encode($herramienta["version"]) . ')';
            $arreglo[] = array('id' => $herramienta["id"], 'text' => $texto);
        }
    } else {
        $texto = ($herramientas == 1) ? "Sin resultados" : "Error";
        $arreglo[] = array('id' => "NO", 'text' => $texto);
    }
} else {
    $arreglo[] = array('id' => "NO", 'text' => "Sin parametros");
}

echo json_encode($arreglo);
