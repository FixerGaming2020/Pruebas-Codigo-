<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$nombre = "Gerencia de Operaciones";
$controlador = new ControladorGerencia();
$creacion = $controlador->crear($nombre);
$mensaje = $controlador->getMensaje();
echo "RESULTADO DE LA OPERACION " . $creacion . " " . $mensaje;
