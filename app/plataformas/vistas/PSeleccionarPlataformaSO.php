<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$arreglo = array();
if (isset($_POST['nombre'])) {
    $controlador = new ControladorPlataformaSO();
    $nombre = $_POST['nombre'];
    $plataformas = $controlador->seleccionar($nombre);
    if (gettype($plataformas) == "resource") {
        while ($plataforma = sqlsrv_fetch_array($plataformas, SQLSRV_FETCH_ASSOC)) {
            $arreglo[] = array('id' => $plataforma["id"], 'text' => utf8_encode($plataforma["nombre"]));
        }
    } else {
        $texto = ($plataformas == 1) ? "Sin resultados" : "Error";
        $arreglo[] = array('id' => "NO", 'text' => $texto);
    }
} else {
    $arreglo[] = array('id' => "NO", 'text' => "Sin parametros");
}

echo json_encode($arreglo);
