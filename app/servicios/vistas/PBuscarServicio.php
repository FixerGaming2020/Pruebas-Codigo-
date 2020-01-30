<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorServicio();

if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $servicios = $controlador->buscar($nombre, $estado);
    $datos = ($nombre) ? "'{$nombre}', " . $estado : "TODOS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $_SESSION['BSERVICIOS'] = array($nombre, $estado, $datos);
} else {
    if (isset($_SESSION['BSERVICIOS'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BSERVICIOS'];
        $nombre = $parametros[0];
        $estado = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $servicios = $controlador->buscar($nombre, $estado);
        $_SESSION['BSERVICIOS'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $servicios = $controlador->listarUltimosCreados();
        $filtro = "Resumen inicial";
        $_SESSION['BSERVICIOS'] = NULL;
    }
}

if (gettype($servicios) == "resource") {
    $filas = $operaciones = "";
    while ($servicio = sqlsrv_fetch_array($servicios, SQLSRV_FETCH_ASSOC)) {
        if ($servicio['estado'] == 'Activo') {
            $operaciones = "
                <button class='btn btn-outline-info datos' 
                    name='{$servicio['id']}' title='Datos básicos'>
                    <i class='fas fa-info-circle'></i>
                </button>
                <button class='btn btn-outline-warning editar' 
                    name='{$servicio['id']}' title='Editar'>
                    <i class='far fa-edit'></i>
                </button>

                <button class='btn btn-outline-danger baja' 
                    name='{$servicio['id']}' title='Dar de baja'>
                    <i class='fas fa-trash'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-info datos' 
                    name='{$servicio['id']}' title='Datos básicos'>
                    <i class='fas fa-info-circle'></i>
                </button>
                <button class='btn btn-outline-success alta' 
                    name='{$servicio['id']}' title='Dar de alta'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= "
            <tr>
                <td class='align-middle'>" . utf8_encode($servicio['sigla']) . "</td>
                <td class='align-middle'>" . utf8_encode($servicio['nombre']) . "</td>
                <td style='display: none;' class='align-middle'>" . utf8_encode($servicio['descripcion']) . "</td>
                <td class='text-center align-middle'>
                    <div class='btn-group btn-group-sm'>
                        {$operaciones}
                    </div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbServicios" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre corto</th>
                        <th>Nombre largo</th>
                        <th style="display: none;">Descripción</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($servicios == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($servicios, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);
echo $formulario;
