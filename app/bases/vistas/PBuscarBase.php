<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorBase();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $motor = $_POST['motor'];
    $collation = $_POST['collation'];
    $datos = ($nombre) ? "'{$nombre}', " : "TODAS, ";
    $datos .= ($motor) ? "'{$motor}', " : "TODOS, ";
    $datos .= ($collation) ? "'{$collation}'" : "TODAS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $bases = $controlador->buscar($nombre, $motor, $collation);
    $_SESSION['BBASES'] = array($nombre, $motor, $collation, $datos);
} else {
    if (isset($_SESSION['BBASES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BBASES'];
        $nombre = $parametros[0];
        $motor = $parametros[1];
        $collation = $parametros[2];
        $filtro = "Ultima búsqueda realizada: " . $parametros[3];
        $bases = $controlador->buscar($nombre, $motor, $collation);
        $_SESSION['BBASES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $bases = $controlador->listarUltimasActualizadas();
        $filtro = "Resumen inicial";
        $_SESSION['BBASES'] = NULL;
    }
}

if (gettype($bases) == "resource") {
    /* SE OBTUVO UN RESULTADO DESDE LA BASE DE DATOS */
    $filas = "";
    while ($base = sqlsrv_fetch_array($bases, SQLSRV_FETCH_ASSOC)) {
        $fechaCreacion = isset($base['bfechaCreacion']) ? date_format($base['bfechaCreacion'], 'd/m/Y') : "";
        $fechaProceso = isset($base['bfechaProceso']) ? date_format($base['bfechaProceso'], 'd/m/Y') : "";
        $filas .= "
            <tr class='fila' title='Haga doble click para acceder a los detalles del elemento'>
                <td>" . utf8_encode($base['bnombre']) . "</td>
                <td>{$fechaCreacion}</td>
                <td style='display: none;'>" . utf8_encode($base['bmotor']) . "</td>
                <td style='display: none;'>" . utf8_encode($base['bcollation']) . "</td>
                <td style='display: none;'>" . utf8_encode($base['pid']) . "</td>
                <td>" . utf8_encode($base['pnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($base['tid']) . "</td>
                <td>" . utf8_encode($base['tnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($base['did']) . "</td>
                <td>" . utf8_encode($base['dnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($base['bestado']) . "</td>
                <td style='display: none;'>" . utf8_encode($base['brti']) . "</td>
                <td style='display: none;'>{$fechaProceso}</td>
                <td style='display: none;'>" . utf8_encode($base['btablas']) . "</td>
                <td style='display: none;'>" . utf8_encode($base['bvistas']) . "</td>
                <td style='display: none;'>" . utf8_encode($base['bprocedimientos']) . "</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        <button class='btn btn-outline-info datos' title='Ver información básica'>
                            <i class='fas fa-info-circle'></i>
                        </button>
                        <button class='btn btn-outline-warning editar' 
                                name='{$base['bid']}' title='Editar'>
                                <i class='far fa-edit'></i>
                        </button>
                        <button class='btn btn-outline-success detalle' 
                            name='{$base['bid']}' title='Detalle/Documentacion'>
                            <i class='far fa-file-pdf'></i>
                        </button>
                    </div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbBases" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha creación</th>
                        <th style="display: none;">Motor</th>
                        <th style="display: none;">Collation</th>
                        <th style="display: none;">IP producción</th>
                        <th>Producción</th>
                        <th style="display: none;">IP test</th>
                        <th>Test</th>
                        <th style="display: none;">IP desarrollo</th>
                        <th>Desarrollo</th>
                        <th style="display: none;">Estado</th>
                        <th style="display: none;">RTI</th>
                        <th style="display: none;">Fecha de proceso</th>
                        <th style="display: none;">Total tablas</th>
                        <th style="display: none;">Total vistas</th>
                        <th style="display: none;">Total SP</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($bases == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($bases, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
