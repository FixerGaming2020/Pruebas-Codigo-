<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();


$codigo = 55;
$sigla = "BA";
$nombre = "Buenos Aires";

$controlador = new ControladorSucursal();


$creacion = $controlador->crear($codigo, $sigla, $nombre);
$mensaje = $controlador->getMensaje();



echo "RESULTADO DE LA OPERACION " . $creacion . " " . $mensaje;
