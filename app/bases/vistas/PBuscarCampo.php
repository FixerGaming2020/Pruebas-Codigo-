<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorColumna();

if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $base = $_POST['base'];
    $tabla = $_POST['tabla'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $datos = ($base) ? "'{$base}', " : "TODAS, ";
    $datos .= ($tabla) ? "'{$tabla}', " : "TODAS, ";
    $datos .= ($nombre) ? "'{$nombre}', " : "TODAS, ";
    $datos .= ($descripcion) ? "'{$descripcion}'" : "TODAS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $campos = $controlador->buscar($base, $tabla, $nombre, $descripcion);
    $_SESSION['BCOLUMNAS'] = array($base, $tabla, $nombre, $descripcion, $datos);
} else {
    if (isset($_SESSION['BCOLUMNAS'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BCOLUMNAS'];
        $base = $parametros[0];
        $tabla = $parametros[1];
        $nombre = $parametros[2];
        $descripcion = $parametros[3];
        $filtro = "Ultima búsqueda realizada: " . $parametros[4];
        $campos = $controlador->buscar($base, $tabla, $nombre, $descripcion);
        $_SESSION['BCOLUMNAS'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $campos = $controlador->listarUltimosActualizados();
        $filtro = "Resumen inicial";
        $_SESSION['BCOLUMNAS'] = NULL;
    }
}

if (gettype($campos) == "resource") {
    /* SE OBTUVO UN RESULTADO DESDE LA BASE DE DATOS */
    $filas = "";
    while ($campo = sqlsrv_fetch_array($campos, SQLSRV_FETCH_ASSOC)) {
        $fechaProceso = isset($campo['cfechaProceso']) ? date_format($campo['cfechaProceso'], 'd/m/Y') : "";
        $filas .= "
            <tr>
                <td>" . utf8_encode($campo['bnombre']) . "</td>
                <td>" . utf8_encode($campo['tnombre']) . "</td>
                <td>" . utf8_encode($campo['cnombre']) . "</td>
                <td>{$campo['cnulos']}</td>
                <td>{$campo['ctipo']}</td>
                <td>{$campo['cmaximo']}</td>
                <td style='display: none;'>" . utf8_encode($campo['cdescripcion']) . "</td>
                <td style='display: none;'>{$fechaProceso}</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        <button class='btn btn-outline-info datos' 
                                name='{$campo['cid']}' title='Ver información básica'>
                                <i class='fas fa-info-circle'></i>
                        </button>
                        <button class='btn btn-outline-warning editar' 
                                name='{$campo['cid']}' title='Editar'>
                                <i class='far fa-edit'></i>
                        </button>
                    </div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbCampos" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Base de datos</th>
                        <th>Tabla</th>
                        <th>Nombre</th>
                        <th>Nulos</th>
                        <th>Tipo</th>
                        <th>Largo</th>
                        <th style="display: none;">Descripción</th>
                        <th style="display: none;">Fecha de proceso</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($campos == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($campos, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
