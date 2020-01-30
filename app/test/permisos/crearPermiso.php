<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$titulo = "Buscar sucursal";
$nivel = 2;
$padre = 9;
$link = "sucursales_buscar";
$formulario = "formBuscarSucursal";

$controlador = new ControladorPermiso();
$creacion = $controlador->crear($titulo, $nivel, $padre, $link, $formulario);
$mensaje = $controlador->getMensaje();
echo "PERMISO <br> RESULTADO DE LA OPERACION:  " . $creacion . ". " . $mensaje;
