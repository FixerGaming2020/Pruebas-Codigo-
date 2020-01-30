<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$id = 11;
$consulta = "EXTERNA";
$descripcion = null;
$controlador = new ControladorVista();
$modificacion = $controlador->modificar($id, $consulta, $descripcion);
$mensaje = $controlador->getMensaje();
echo "RESULTADO DE LA OPERACION " . $modificacion . " " . $mensaje;

