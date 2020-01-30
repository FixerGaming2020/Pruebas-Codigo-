<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorComunicacion();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $datos = ($nombre) ? "'{$nombre}', " . $estado : "TODAS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $comunicaciones = $controlador->buscar($nombre, $estado);
    $_SESSION['BCOMUNICACIONES'] = array($nombre, $estado, $datos);
} else {
    if (isset($_SESSION['BCOMUNICACIONES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BCOMUNICACIONES'];
        $nombre = $parametros[0];
        $estado = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $comunicaciones = $controlador->buscar($nombre, $estado);
        $_SESSION['BCOMUNICACIONES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $comunicaciones = $controlador->listarUltimasCreadas();
        $filtro = "Resumen inicial";
        $_SESSION['BCOMUNICACIONES'] = NULL;
    }
}

if (gettype($comunicaciones) == "resource") {
    $filas = "";
    while ($comunicacion = sqlsrv_fetch_array($comunicaciones, SQLSRV_FETCH_ASSOC)) {
        if ($comunicacion['cestado'] == 'Activa') {
            $operaciones = "
                <button class='btn btn-outline-info datos' 
                        name='{$comunicacion['cid']}' title='Datos básicos'>
                        <i class='fas fa-info-circle'></i>
                </button>
                <button class='btn btn-outline-warning editar' 
                        name='{$comunicacion['cid']}' title='Editar'>
                        <i class='far fa-edit'></i>
                </button>
                <button class='btn btn-outline-danger baja' 
                        name='{$comunicacion['cid']}' title='Dar de baja'>
                        <i class='fas fa-trash'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-info datos' 
                        name='{$comunicacion['cid']}' title='Datos básicos'>
                        <i class='fas fa-info-circle'></i>
                </button>
                <button class='btn btn-outline-success alta' 
                        name='{$comunicacion['cid']}' title='Dar de alta'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= "
            <tr>
                <td style='display: none;'>" . utf8_encode($comunicacion['csigla']) . "</td>
                <td>" . utf8_encode($comunicacion['cnombre']) . "</td>
                <td>" . utf8_encode($comunicacion['gnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['enombre']) . "</td>
                <td>" . utf8_encode($comunicacion['enombre']) . "</td> 
                <td>" . utf8_encode($comunicacion['snombre']) . "</td> 
                <td>" . utf8_encode($comunicacion['pnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['ccantidad']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['cdescripcion']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['crti']) . "</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbComunicaciones" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th style="display: none;">Nombre corto</th>
                        <th>Nombre largo</th>
                        <th>Gerencia</th>
                        <th style="display: none;">Legajo</th>
                        <th>Delegado</th>
                        <th>Ubicación</th>
                        <th>Proveedor</th>
                        <th style="display: none;">Cantidad</th>
                        <th style="display: none;">Descripción</th>
                        <th style="display: none;">RTI</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($comunicaciones == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($comunicaciones, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
