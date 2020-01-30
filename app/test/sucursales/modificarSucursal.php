<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();


$codigo = 55;
$sigla = "BA";
$nombre = "Buenos aires";

$controlador = new ControladorSucursal();
$modificacion = $controlador->modificar($codigo, $sigla, $nombre);
$mensaje = $controlador->getMensaje();
echo "RESULTADO DE LA OPERACION " . $modificacion . " " . $mensaje;

