<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$arreglo = array();
if (isset($_POST['nombre']) && isset($_POST['tipo'])) {
    $controlador = new ControladorSitio();
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $sitios = $controlador->seleccionar($nombre, $tipo);
    if (gettype($sitios) == "resource") {
        while ($sitio = sqlsrv_fetch_array($sitios, SQLSRV_FETCH_ASSOC)) {
            $arreglo[] = array('id' => $sitio["id"], 'text' => utf8_encode($sitio["nombre"]));
        }
    } else {
        $texto = ($sitios == 1) ? "Sin resultados" : "Error";
        $arreglo[] = array('id' => "NO", 'text' => $texto);
    }
} else {
    $arreglo[] = array('id' => "NO", 'text' => "Sin parametros");
}

echo json_encode($arreglo);


