<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$descripcion = "Inventario para inventariar algo";
$controlador = new ControladorInventario();
$creacion = $controlador->crear($descripcion);
$mensaje = $controlador->getMensaje();
echo "RESULTADO DE LA OPERACION " . $creacion . " " . $mensaje;
