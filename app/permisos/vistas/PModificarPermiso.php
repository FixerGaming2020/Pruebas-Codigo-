<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$exito = FALSE;
if (isset($_POST['idPermiso'])) {
    $id = $_POST['idPermiso'];
    $titulo = $_POST['titulo'];
    $nivel = $_POST['nivel'];
    $padre = ($nivel == 2) ? $_POST['padre'] : 0;
    $link = ($nivel == 2) ? $_POST['link'] : "";
    $controlador = new ControladorPermiso();
    $modificacion = $controlador->modificar($id, $titulo, $nivel, $padre, $link);
    $mensaje = $controlador->getMensaje();
    $exito = ($modificacion == 2) ? true : false;
    $resultado = ControladorHTML::getAlertaOperacion($modificacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
