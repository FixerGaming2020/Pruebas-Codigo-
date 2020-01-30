<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$nombre = "MGSConsulting";
$telefono = "0296615353984";
$correo = "proveedor@mgsconsulting.com";
$provincia = "Santa Fe";
$localidad = "Rosario";
$direccion = "Rio Gallegos 456 piso N° 2";
$controlador = new ControladorProveedor();
$creacion = $controlador->crear($nombre, $telefono, $correo, $provincia, $localidad, $direccion);
$mensaje = $controlador->getMensaje();
echo "RESULTADO DE LA OPERACION " . $creacion . " " . $mensaje;
