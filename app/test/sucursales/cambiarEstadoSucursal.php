<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$codigo = 55;
$estado = 2;
$controlador = new ControladorSucursal();
$modificacion = $controlador->cambiarEstado($codigo, $estado);
$mensaje = $controlador->getMensaje();
echo "RESULTADO DE LA OPERACION " . $modificacion . " " . $mensaje;
