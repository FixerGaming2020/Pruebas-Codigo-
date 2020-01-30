<?php

/*
 * BUSCAR APLICACION (SEGUNDO PASO) CORRESPONDIENTE A TECNOLOGIA
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
    $tipo = $_POST['tipo'];
    $datos = ($sigla) ? "'{$sigla}', " : "TODAS, ";
    $datos .= ($nombre) ? "'{$nombre}', " . $tipo : "TODAS, " . $tipo;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $aplicaciones = $controlador->buscarSP($sigla, $nombre, $tipo);
    $_SESSION['BSPAPLICACIONES'] = array($sigla, $nombre, $tipo, $datos);
} else {
    if (isset($_SESSION['BSPAPLICACIONES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BSPAPLICACIONES'];
        $sigla = $parametros[0];
        $nombre = $parametros[1];
        $tipo = $parametros[2];
        $filtro = "Ultima búsqueda realizada: " . $parametros[3];
        $aplicaciones = $controlador->buscarSP($sigla, $nombre, $tipo);
        $_SESSION['BSPAPLICACIONES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $aplicaciones = $controlador->listarUltimasCreadas();
        $filtro = "Resumen inicial";
        $_SESSION['BSPAPLICACIONES'] = NULL;
    }
}

if (gettype($aplicaciones) == "resource") {
    $filas = "";
    while ($aplicacion = sqlsrv_fetch_array($aplicaciones, SQLSRV_FETCH_ASSOC)) {
        $filas .= "
            <tr>
                <td>" . utf8_encode($aplicacion['asigla']) . "</td>
                <td>" . utf8_encode($aplicacion['anombre']) . "</td>
                <td>" . utf8_encode($aplicacion['atipo']) . "</td>
                <td>" . utf8_encode($aplicacion['aseguridad']) . "</td>
                <td>" . utf8_encode($aplicacion['atecnologia']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['pnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['hnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['hversion']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['lnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['lversion']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['bnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['mnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['unombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['gnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['enombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['snombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['apuertoProduccion']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['tnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['apuertoTest']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['dnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['apuertoDesarrollo']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['arti']) . "</td>
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
                        <th>Tipo</th>
                        <th>Seguridad</th>
                        <th>Técnologia</th>
                        <th style="display: none;">Proveedor</th>
                        <th style="display: none;">Nombre herramienta</th>
                        <th style="display: none;">Versión herramienta</th>
                        <th style="display: none;">Nombre lenguaje</th>
                        <th style="display: none;">Versión lenguaje</th>
                        <th style="display: none;">Base de datos</th>
                        <th style="display: none;">Modo</th>
                        <th style="display: none;">Lugar</th>
                        <th style="display: none;">Gerencia</th>
                        <th style="display: none;">Delegado</th>
                        <th style="display: none;">Servidor producción</th>
                        <th style="display: none;">Puerto producción</th>
                        <th style="display: none;">Servidor test</th>
                        <th style="display: none;">Puerto test</th>
                        <th style="display: none;">Servidor desarrollo</th>
                        <th style="display: none;">Puerto desarrollo</th>
                        <th style="display: none;">RTI</th>
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
