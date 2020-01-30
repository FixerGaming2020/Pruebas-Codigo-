<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorVista();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $base = $_POST['base'];
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $datos = ($base) ? "'{$base}', " : "TODAS, ";
    $datos .= ($nombre) ? "'{$nombre}', " : "TODAS, ";
    $datos .= ($tipo) ? "'{$tipo}', " : "TODOS, ";
    $datos .= ($descripcion) ? "'{$descripcion}'" : "TODAS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $vistas = $controlador->buscar($base, $nombre, $tipo, $descripcion);
    $_SESSION['BVISTAS'] = array($base, $nombre, $tipo, $descripcion, $datos);
} else {
    if (isset($_SESSION['BVISTAS'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BVISTAS'];
        $base = $parametros[0];
        $nombre = $parametros[1];
        $tipo = $parametros[2];
        $descripcion = $parametros[3];
        $filtro = "Ultima búsqueda realizada: " . $parametros[4];
        $vistas = $controlador->buscar($base, $nombre, $tipo, $descripcion);
        $_SESSION['BVISTAS'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $vistas = $controlador->listarUltimasActualizadas();
        $filtro = "Resumen inicial";
        $_SESSION['BVISTAS'] = NULL;
    }
}

if (gettype($vistas) == "resource") {
    $filas = "";
    while ($vista = sqlsrv_fetch_array($vistas, SQLSRV_FETCH_ASSOC)) {
        $fechaProceso = date_format($vista['vfechaProceso'], 'd/m/Y');
        $filas .= "
            <tr>
                <td>" . utf8_encode($vista['bnombre']) . "</td>
                <td>" . utf8_encode($vista['vnombre']) . "</td>
                <td>{$vista['vtipoConsulta']}</td>
                <td>{$fechaProceso}</td>
                <td style='display: none;'>" . utf8_encode($vista['vdescripcion']) . "</td>  
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        <button class='btn btn-outline-info datos' 
                                name='{$vista['vid']} title='Ver información básica'>
                                <i class='fas fa-info-circle'></i>
                        </button>
                        <button class='btn btn-outline-warning editar' 
                                name='{$vista['vid']}' title='Editar'>
                            <i class='far fa-edit'></i>
                        </button>
                    </div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbVistas" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Base de datos</th>
                        <th>Nombre</th>
                        <th>Tipo de consulta</th>
                        <th>Fecha proceso</th>
                        <th style="display: none;">Descripción</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($vistas == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($vistas, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
