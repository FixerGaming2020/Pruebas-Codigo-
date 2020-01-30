<?php

/*
 * BUSCAR APLICACION (SEGUNDO PASO) CORRESPONDIENTE A PROTECCION DE ACTIVOS DE LA
 * INFORMACION.
 */

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorAplicacion();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $sigla = $_POST['sigla'];
    $nombre = $_POST['nombre'];
    $datos = ($sigla) ? "'{$sigla}', " : "TODAS, ";
    $datos .= ($nombre) ? "'{$nombre}'" : "TODAS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $aplicaciones = $controlador->buscarTP($sigla, $nombre);
    $_SESSION['BTPAPLICACIONES'] = array($sigla, $nombre, $datos);
} else {
    if (isset($_SESSION['BTPAPLICACIONES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BTPAPLICACIONES'];
        $sigla = $parametros[0];
        $nombre = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $aplicaciones = $controlador->buscarTP($sigla, $nombre);
        $_SESSION['BTPAPLICACIONES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $aplicaciones = $controlador->listarUltimasCreadas();
        $filtro = "Resumen inicial";
        $_SESSION['BTPAPLICACIONES'] = NULL;
    }
}

if (gettype($aplicaciones) == "resource") {
    $filas = "";
    while ($aplicacion = sqlsrv_fetch_array($aplicaciones, SQLSRV_FETCH_ASSOC)) {
        $filas .= "
            <tr>
                <td>" . utf8_encode($aplicacion['asigla']) . "</td>
                <td>" . utf8_encode($aplicacion['anombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['atipo']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['aseguridad']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['atecnologia']) . "</td> 
                <td style='display: none;'>" . utf8_encode($aplicacion['pnombre']) . "</td> 
                <td>" . utf8_encode($aplicacion['confidencialidad']) . "</td> 
                <td>" . utf8_encode($aplicacion['integridad']) . "</td> 
                <td>" . utf8_encode($aplicacion['disponibilidad']) . "</td> 
                <td>" . utf8_encode($aplicacion['criticidad']) . "</td> 
                <td style='display: none;'>" . utf8_encode($aplicacion['adescripcion']) . "</td> 
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        <button class='btn btn-outline-info datos' 
                                name='{$aplicacion['aid']}' title='Datos básicos'>
                                <i class='fas fa-info-circle'></i>
                        </button>
                        <button class='btn btn-outline-warning editar' 
                                name='{$aplicacion['aid']}' title='Editar'>
                                <i class='far fa-edit'></i>
                        </button>
                    </div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbAplicaciones" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre corto</th>
                        <th>Nombre largo</th>
                        <th style="display: none;">Tipo</th>
                        <th style="display: none;">Seguridad</th>
                        <th style="display: none;">Técnologia</th>
                        <th style="display: none;">Proveedor</th>
                        <th>Confidencialidad</th>
                        <th>Integridad</th>
                        <th>Disponibilidad</th>
                        <th>Criticidad</th>
                        <th style="display: none;">Descripción</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($aplicaciones == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($aplicaciones, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;

