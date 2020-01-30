<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$arreglo = array();
if (isset($_POST['nombre'])) {
    $controlador = new ControladorGerencia();
    $nombre = $_POST['nombre'];
    $gerencias = $controlador->seleccionar($nombre);
    if (gettype($gerencias) == "resource") {
        while ($gerencia = sqlsrv_fetch_array($gerencias, SQLSRV_FETCH_ASSOC)) {
            $arreglo[] = array('id' => $gerencia["gid"], 'text' => utf8_encode($gerencia["gnombre"]));
        }
    } else {
        $texto = ($gerencias == 1) ? "Sin resultados" : "Error";
        $arreglo[] = array('id' => "NO", 'text' => $texto);
    }
} else {
    $arreglo[] = array('id' => "NO", 'text' => "Sin parametros");
}

echo json_encode($arreglo);
