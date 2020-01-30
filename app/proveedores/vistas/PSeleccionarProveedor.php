<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$arreglo = array();
if (isset($_POST['nombre'])) {
    $controlador = new ControladorProveedor();
    $nombre = $_POST['nombre'];
    $proveedores = $controlador->seleccionar($nombre);
    if (gettype($proveedores) == "resource") {
        while ($proveedor = sqlsrv_fetch_array($proveedores, SQLSRV_FETCH_ASSOC)) {
            $arreglo[] = array('id' => $proveedor["id"], 'text' => utf8_encode($proveedor["nombre"]));
        }
    } else {
        $texto = ($proveedores == 1) ? "Sin resultados" : "Error";
        $arreglo[] = array('id' => "NO", 'text' => $texto);
    }
} else {
    $arreglo[] = array('id' => "NO", 'text' => "Sin parametros");
}

echo json_encode($arreglo);
