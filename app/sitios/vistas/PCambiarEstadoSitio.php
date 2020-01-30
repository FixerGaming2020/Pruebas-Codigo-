<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

if (isset($_POST['mcesAccion'])) {
    $codigo = $_POST['mcesIdSitio'];
    $controlador = new ControladorSitio();
    $estado = ($_POST['mcesAccion'] == "ALTA") ? 'Activo' : 'Inactivo';
    $modificacion = $controlador->cambiarEstado($codigo, $estado);
    $mensaje = $controlador->getMensaje();
    $exito = ($modificacion == 2) ? TRUE : FALSE;
    $resultado = ControladorHTML::getAlertaOperacion($modificacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

echo $resultado;
