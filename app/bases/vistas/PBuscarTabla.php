<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorTabla();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $base = $_POST['base'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $datos = ($base) ? "'" . $base . "', " : "TODAS, ";
    $datos .= ($nombre) ? "'" . $nombre . "', " : "TODAS, ";
    $datos .= ($descripcion) ? "'" . $descripcion . "'" : "TODAS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $tablas = $controlador->buscar($base, $nombre, $descripcion);
    $_SESSION['BTABLAS'] = array($base, $nombre, $descripcion, $datos);
} else {
    if (isset($_SESSION['BTABLAS'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BTABLAS'];
        $base = $parametros[0];
        $nombre = $parametros[1];
        $descripcion = $parametros[2];
        $filtro = "Ultima búsqueda realizada: " . $parametros[3];
        $tablas = $controlador->buscar($base, $nombre, $descripcion);
        $_SESSION['BTABLAS'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $tablas = $controlador->listarUltimasModificadas();
        $filtro = "Resumen inicial";
        $_SESSION['BTABLAS'] = NULL;
    }
}

if (gettype($tablas) == "resource") {
    /* SE OBTUVO UN RESULTADO DESDE LA BASE DE DATOS */
    $filas = "";
    while ($tabla = sqlsrv_fetch_array($tablas, SQLSRV_FETCH_ASSOC)) {
        $fechaCreacion = isset($tabla['tfechaCreacion']) ? date_format($tabla['tfechaCreacion'], 'd/m/Y') : "";
        $fechaEdicion = isset($tabla['tfechaEdicion']) ? date_format($tabla['tfechaEdicion'], 'd/m/Y') : "";
        $fechaProceso = isset($tabla['tfechaProceso']) ? date_format($tabla['tfechaProceso'], 'd/m/Y') : "";
        $filas .= "
            <tr>
                <td>" . utf8_encode($tabla['bnombre']) . "</td>
                <td>" . utf8_encode($tabla['tnombre']) . "</td>
                <td>{$fechaCreacion}</td>
                <td>{$fechaEdicion}</td>
                <td>{$fechaProceso}</td>
                <td style='display: none;'>" . utf8_encode($tabla['tdescripcion']) . "</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        <button class='btn btn-outline-info datos' 
                                name='{$tabla['tid']}' title='Ver información básica'>
                                <i class='fas fa-info-circle'></i>
                        </button>
                        <button class='btn btn-outline-warning editar' 
                                name='{$tabla['tid']}' title='Editar'>
                                <i class='far fa-edit'></i>
                        </button>
                        <button class='btn btn-outline-success detalle' 
                            name='{$tabla['tid']}' title='Detalle/Documentacion'>
                                <i class='far fa-file-pdf'></i>
                        </button>
                    </div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbTablas" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Base de datos</th>
                        <th>Nombre</th>
                        <th>Creación</th>
                        <th>Modificación</th>
                        <th>Proceso</th>
                        <th style="display: none;">Descripción</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($tablas == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($tablas, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
