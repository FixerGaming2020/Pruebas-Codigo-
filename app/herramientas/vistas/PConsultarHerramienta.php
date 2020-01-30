<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorHerramientaDesarrollo();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $version = $_POST['version'];
    $fabricante = $_POST['fabricante'];
    $datos = ($nombre) ? "'{$nombre}', " : "TODOS, ";
    $datos .= ($version) ? "'{$version}', " : "TODAS, ";
    $datos .= ($fabricante) ? "'{$fabricante}'" : "TODOS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $herramientas = $controlador->consultar($nombre, $version, $fabricante);
    $_SESSION['CHERRAMIENTAS'] = array($nombre, $version, $fabricante, $datos);
} else {
    if (isset($_SESSION['CHERRAMIENTAS'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['CHERRAMIENTAS'];
        $nombre = $parametros[0];
        $version = $parametros[1];
        $fabricante = $parametros[2];
        $filtro = "Ultima búsqueda realizada: " . $parametros[3];
        $herramientas = $controlador->consultar($nombre, $version, $fabricante);
        $_SESSION['CHERRAMIENTAS'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $herramientas = $controlador->listarUltimasCreadas();
        $filtro = "Resumen inicial";
        $_SESSION['CHERRAMIENTAS'] = NULL;
    }
}

if (gettype($herramientas) == "resource") {
    $filas = "";
    while ($herramienta = sqlsrv_fetch_array($herramientas, SQLSRV_FETCH_ASSOC)) {
        $filas .= "
            <tr>
                <td>" . utf8_encode($herramienta['nombre']) . "</td>
                <td>" . utf8_encode($herramienta['version']) . "</td>
                <td>" . utf8_encode($herramienta['fabricante']) . "</td>
                <td>" . utf8_encode($herramienta['descripcion']) . "</td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbHerramientas" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Versión</th>
                        <th>Fabricante</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($herramientas == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($herramientas, $mensaje);
}

echo ControladorHTML::getCardBusqueda($filtro, $cuerpo);
