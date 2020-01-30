<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

if ($_GET['ref']) {
    $idProcedimiento = $_GET['ref'];
    $procedimiento = new Procedimiento($idProcedimiento);
    $resultado = $procedimiento->obtener();
    if ($resultado == 2) {
        $sp = $procedimiento->getNombre();
        $base = $procedimiento->getBase();
        $nombre = $base . "_" . $sp . ".sql";
        $descripcion = $procedimiento->getDefinicion();
    } else {
        $nombre = "SP.txt";
        $descripcion = $procedimiento->getMensaje();
    }
} else {
    $nombre = "SP.txt";
    $descripcion = "No se pudo hacer referencia al procedimiento";
}

header("Pragma: public");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
header("Content-Description: File Transfer");
header("Content-Type: application/force-download");
header("Content-Disposition: attachment; filename=" . $nombre);
echo $descripcion;
