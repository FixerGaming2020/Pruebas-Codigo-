<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorLenguaje();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $version = $_POST['version'];
    $datos = ($nombre) ? "'{$nombre}', " : "TODOS, ";
    $datos .= ($version) ? "'{$version}'" : "TODAS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $lenguajes = $controlador->consultar($nombre, $version);
    $_SESSION['CLENGUAJES'] = array($nombre, $version, $datos);
} else {
    if (isset($_SESSION['CLENGUAJES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['CLENGUAJES'];
        $nombre = $parametros[0];
        $version = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $lenguajes = $controlador->consultar($nombre, $version);
        $_SESSION['CLENGUAJES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $lenguajes = $controlador->listarUltimosCreados();
        $filtro = "Resumen inicial";
        $_SESSION['CLENGUAJES'] = NULL;
    }
}

if (gettype($lenguajes) == "resource") {
    $filas = "";
    while ($lenguaje = sqlsrv_fetch_array($lenguajes, SQLSRV_FETCH_ASSOC)) {
        $filas .= "
            <tr>
                <td>" . utf8_encode($lenguaje['nombre']) . "</td>
                <td>" . utf8_encode($lenguaje['version']) . "</td>
                <td>" . utf8_encode($lenguaje['descripcion']) . "</td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbLenguajes" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Versión</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($lenguajes == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($lenguajes, $mensaje);
}

echo ControladorHTML::getCardBusqueda($filtro, $cuerpo);


