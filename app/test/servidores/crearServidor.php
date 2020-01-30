<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$nombre = "VM000DB03";
$ip = "172.26.100.47";
$ambiente = 1;
$tipo = 1;
$descripcion = "Servidor de aplicaciones para Workflow";
$controlador = new ControladorServidor();
$creacion = $controlador->crear($nombre, $ip, $ambiente, $tipo, $descripcion);
$mensaje = $controlador->getMensaje();
echo "RESULTADO DE LA OPERACION " . $creacion . " " . $mensaje;


