<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$sigla = "INTRA";
$nombre = "Intranet Banco Santa Cruz";
$inventario = 1;
$departamento = 1;
$disponibilidad = 3;
$integridad = 3;
$confidencialidad = 2;
$autenticidad = 3;
$rti = "SI";
$controlador = new ControladorServicioInterno();
$creacion = $controlador->crear($sigla, $nombre, $inventario, $departamento, $disponibilidad, $integridad, $confidencialidad, $autenticidad, $rti);
$mensaje = $controlador->getMensaje();
echo "RESULTADO DE LA OPERACION " . $creacion . " " . $mensaje;
