<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$arreglo = array();
if (isset($_POST['nombre']) && isset($_POST['estado'])) {
    $controlador = new ControladorPerfil();
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $perfiles = $controlador->seleccionar($nombre, $estado);
    if (gettype($perfiles) == "resource") {
        while ($perfil = sqlsrv_fetch_array($perfiles, SQLSRV_FETCH_ASSOC)) {
            $arreglo[] = array('id' => $perfil["id"], 'text' => utf8_encode($perfil["nombre"]));
        }
    } else {
        $texto = ($perfiles == 1) ? "Sin resultados" : "Error";
        $arreglo[] = array('id' => "NO", 'text' => $texto);
    }
} else {
    $arreglo[] = array('id' => "NO", 'text' => "Sin parametros");
}
echo json_encode($arreglo);
