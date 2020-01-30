<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$arreglo = array();
if (isset($_POST['nombre'])) {
    $controlador = new ControladorTabla();
    $nombre = $_POST['nombre'];
    $tablas = $controlador->listar($nombre);
    if (gettype($tablas) == "resource") {
        while ($tabla = sqlsrv_fetch_array($tablas, SQLSRV_FETCH_ASSOC)) {
            $arreglo[] = array('id' => $tabla["idTabla"], 'text' => utf8_encode($tabla["nombreTabla"]));
        }
    } else {
        $texto = ($tablas == 1) ? "Sin resultados" : "Error";
        $arreglo[] = array('id' => "NO", 'text' => $texto);
    }
} else {
    $arreglo[] = array('id' => "NO", 'text' => "Sin parametros");
}

echo json_encode($arreglo);

