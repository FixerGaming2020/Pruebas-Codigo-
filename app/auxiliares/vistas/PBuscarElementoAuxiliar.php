<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorAuxiliar();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $datos = ($nombre) ? "'{$nombre}', " . $estado : "TODOS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $auxiliares = $controlador->buscar($nombre, $estado);
    $_SESSION['BAUXILIARES'] = array($nombre, $estado, $datos);
} else {
    if (isset($_SESSION['BAUXILIARES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BAUXILIARES'];
        $nombre = $parametros[0];
        $estado = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $auxiliares = $controlador->buscar($nombre, $estado);
        $_SESSION['BAUXILIARES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $auxiliares = $controlador->listarUltimosCreados();
        $filtro = "Resumen inicial";
        $_SESSION['BAUXILIARES'] = NULL;
    }
}

if (gettype($auxiliares) == "resource") {
    $filas = "";
    while ($auxiliar = sqlsrv_fetch_array($auxiliares, SQLSRV_FETCH_ASSOC)) {
        if ($auxiliar['aestado'] == 'Activo') {
            $operaciones = "
                <button class='btn btn-outline-info datos' 
                        name='{$auxiliar['aid']}' title='Datos básicos'>
                        <i class='fas fa-info-circle'></i>
                </button>
                <button class='btn btn-outline-warning editar' 
                        name='{$auxiliar['aid']}' title='Editar'>
                        <i class='far fa-edit'></i>
                </button>
                <button class='btn btn-outline-danger baja' 
                        name='{$auxiliar['aid']}' title='Dar de baja'>
                        <i class='fas fa-trash'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-info datos' 
                        name='{$auxiliar['aid']}' title='Datos básicos'>
                        <i class='fas fa-info-circle'></i>
                </button>
                <button class='btn btn-outline-success alta' 
                        name='{$auxiliar['aid']}' title='Dar de alta'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= "
            <tr>
                <td style='display: none;'>" . utf8_encode($auxiliar['asigla']) . "</td>
                <td>" . utf8_encode($auxiliar['anombre']) . "</td>
                <td>" . utf8_encode($auxiliar['gnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($auxiliar['eid']) . "</td>
                <td>" . utf8_encode($auxiliar['enombre']) . "</td> 
                <td>" . utf8_encode($auxiliar['snombre']) . "</td> 
                <td style='display: none;'>" . utf8_encode($auxiliar['acantidad']) . "</td>
                <td style='display: none;'>" . utf8_encode($auxiliar['adescripcion']) . "</td>
                <td style='display: none;'>" . utf8_encode($auxiliar['arti']) . "</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbAuxiliares" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr >
                        <th style="display: none;">Nombre corto</th>
                        <th>Nombre largo</th>
                        <th>Gerencia</th>
                        <th style="display: none;">Legajo</th>
                        <th>Delegado</th>
                        <th>Ubicación</th>
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
    $mensaje .= ($auxiliares == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($auxiliares, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
