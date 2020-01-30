<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$arreglo = array();
if ($_POST['nombre']) {
    $controlador = new ControladorInventario();
    $nombre = $_POST['nombre'];
    $inventarios = $controlador->seleccionar($nombre);
    if (gettype($inventarios) == "resource") {
        while ($inventario = sqlsrv_fetch_array($inventarios, SQLSRV_FETCH_ASSOC)) {
            $arreglo[] = array('id' => $inventario["id"], 'text' => $inventario["id"]);
        }
    } else {
        $texto = ($inventarios == 1) ? "Sin resultados" : "Error";
        $arreglo[] = array('id' => "NO", 'text' => $texto);
    }
} else {
    $arreglo[] = array('id' => "NO", 'text' => "Sin parametros");
}

echo json_encode($arreglo);
