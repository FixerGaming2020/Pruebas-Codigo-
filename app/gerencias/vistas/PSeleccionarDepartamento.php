<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$arreglo = array();
if (isset($_POST['nombre'])) {
    $controlador = new ControladorDepartamento();
    $nombre = $_POST['nombre'];
    $deparamentos = $controlador->seleccionar($nombre);
    if (gettype($deparamentos) == "resource") {
        while ($deparamento = sqlsrv_fetch_array($deparamentos, SQLSRV_FETCH_ASSOC)) {
            $arreglo[] = array('id' => $deparamento["did"], 'text' => utf8_encode($deparamento["dnombre"]));
        }
    } else {
        $texto = ($deparamentos == 1) ? "Sin resultados" : "Error";
        $arreglo[] = array('id' => "NO", 'text' => $texto);
    }
} else {
    $arreglo[] = array('id' => "NO", 'text' => "Sin parametros");
}

echo json_encode($arreglo);
