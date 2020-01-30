<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$arreglo = array();
if (isset($_POST['nombre']) && isset($_POST['ambiente']) && isset($_POST['tipo'])) {
    $controlador = new ControladorServidor();
    $nombre = $_POST['nombre'];
    $ambiente = $_POST['ambiente'];
    $tipo = $_POST['tipo'];
    $servidores = $controlador->seleccionar($nombre, $ambiente, $tipo);
    if (gettype($servidores) == "resource") {
        while ($servidor = sqlsrv_fetch_array($servidores, SQLSRV_FETCH_ASSOC)) {
            $arreglo[] = array('id' => $servidor["id"], 'text' => utf8_encode($servidor["nombre"]));
        }
    } else {
        $texto = ($servidores == 1) ? "Sin resultados" : "Error";
        $arreglo[] = array('id' => "NO", 'text' => $texto);
    }
} else {
    $arreglo[] = array('id' => "NO", 'text' => "Sin parametros");
}

echo json_encode($arreglo);
