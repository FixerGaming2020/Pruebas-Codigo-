<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$nombre = "Erica Gomez";
$telefono = "011491103";
$correo = "mesa_ayuda@mgsconsulting.com";
$proveedor = 3;

$controlador = new ControladorResponsable();
$creacion = $controlador->crear($nombre, $telefono, $correo, $proveedor);
$mensaje = $controlador->getMensaje();
echo "RESPOSABLE <BR> RESULTADO DE LA OPERACION: " . $creacion . ". " . $mensaje;