<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorProcedimiento();

if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $base = $_POST['base'];
    $nombre = $_POST['nombre'];
    $definicion = $_POST['definicion'];
    $descripcion = $_POST['descripcion'];
    $datos = ($base) ? "'{$base}', " : "TODAS, ";
    $datos .= ($nombre) ? "'{$nombre}', " : "TODOS, ";
    $datos .= ($definicion) ? "'{$definicion}', " : "TODOS, ";
    $datos .= ($descripcion) ? "'{$descripcion}'" : "TODAS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $procedimientos = $controlador->buscar($base, $nombre, $definicion, $descripcion);
    $_SESSION['BPROCEDIMIENTOS'] = array($base, $nombre, $definicion, $descripcion, $datos);
} else {
    if (isset($_SESSION['BPROCEDIMIENTOS'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BPROCEDIMIENTOS'];
        $base = $parametros[0];
        $nombre = $parametros[1];
        $definicion = $parametros[2];
        $descripcion = $parametros[3];
        $filtro = "Ultima búsqueda realizada: " . $parametros[4];
        $procedimientos = $controlador->buscar($base, $nombre, $definicion, $descripcion);
        $_SESSION['BPROCEDIMIENTOS'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $procedimientos = $controlador->listarUltimosModificados();
        $filtro = "Resumen inicial";
        $_SESSION['BPROCEDIMIENTOS'] = NULL;
    }
}

if (gettype($procedimientos) == "resource") {
    /* SE OBTUVO UN RESULTADO DESDE LA BASE DE DATOS */
    $filas = "";
    while ($procedimiento = sqlsrv_fetch_array($procedimientos, SQLSRV_FETCH_ASSOC)) {
        $fechaCreacion = isset($procedimiento['pfechaCreacion']) ? date_format($procedimiento['pfechaCreacion'], 'd/m/Y') : "";
        $fechaEdicion = isset($procedimiento['pfechaEdicion']) ? date_format($procedimiento['pfechaEdicion'], 'd/m/Y H:i:s') : "";
        $filas .= "
            <tr>
                <td>" . utf8_encode($procedimiento['bnombre']) . "</td>
                <td>" . utf8_encode($procedimiento['pnombre']) . "</td>
                <td>{$fechaCreacion}</td>
                <td>{$fechaEdicion}</td>
                <td style='display: none;'>" . utf8_encode($procedimiento['pdescripcion']) . "</td> 
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        <button class='btn btn-outline-info datos' title='Ver información básica'>
                            <i class='fas fa-info-circle'></i>
                        </button>
                        <button class='btn btn-outline-warning editar' 
                                name='{$procedimiento['pid']}' title='Editar'>
                            <i class='far fa-edit'></i>
                        </button>
                        <a href='PDescargarSQLProcedimiento.php?ref={$procedimiento['pid']}' 
                            class='btn btn-outline-success' title='Descargar .SQL'>
                            <i class='fas fa-download'></i>
                        </a>
                    </div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbProcedimientos" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Base de datos</th>
                        <th>Nombre</th>
                        <th>Fecha creación</th>
                        <th>Fecha edición</th>
                        <th style="display: none;">Descripción</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($procedimientos == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($procedimientos, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
