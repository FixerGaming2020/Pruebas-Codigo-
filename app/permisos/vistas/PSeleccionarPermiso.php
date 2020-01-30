<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();

$arreglo = array();
if (isset($_POST['nombre']) && isset($_POST['nivel'])) {
    $controlador = new ControladorPermiso();
    $nombre = $_POST['nombre'];
    $nivel = $_POST['nivel'];
    $permisos = $controlador->seleccionar($nombre, $nivel);
    if (gettype($permisos) == "resource") {
        while ($permiso = sqlsrv_fetch_array($permisos, SQLSRV_FETCH_ASSOC)) {
            $arreglo[] = array('id' => $permiso["id"], 'text' => utf8_encode($permiso["titulo"]));
        }
    } else {
        $texto = ($permisos == 1) ? "Sin resultados" : "Error";
        $arreglo[] = array('id' => "NO", 'text' => $texto);
    }
} else {
    $arreglo[] = array('id' => "NO", 'text' => "Sin parametros");
}

echo json_encode($arreglo);
