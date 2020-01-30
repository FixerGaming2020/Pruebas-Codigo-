<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();

$controlador = new ControladorProveedor();
session_start();

if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $datos = ($nombre) ? "'{$nombre}', " . $estado : "TODAS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $proveedores = $controlador->buscar($nombre, $estado);
    $_SESSION['BPROVEEDORES'] = array($nombre, $estado, $datos);
} else {
    if (isset($_SESSION['BPROVEEDORES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BPROVEEDORES'];
        $nombre = $parametros[0];
        $estado = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $proveedores = $controlador->buscar($nombre, $estado);
        $_SESSION['BPROVEEDORES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $proveedores = $controlador->listarUltimosCreados();
        $filtro = "Resumen inicial";
        $_SESSION['BPROVEEDORES'] = NULL;
    }
}

if (gettype($proveedores) == "resource") {
    /* SE OBTUVO UN RESULTADO DESDE LA BASE DE DATOS */
    $filas = "";
    while ($proveedor = sqlsrv_fetch_array($proveedores, SQLSRV_FETCH_ASSOC)) {
        if ($proveedor['estado'] == 'Activo') {
            $operaciones = "
                <button class='btn btn-outline-info datos' 
                    title='Ver información básica'><i class='fas fa-info-circle'></i>
                </button>
                <button class='btn btn-outline-warning editar' 
                    name='{$proveedor['id']}' title='Editar'><i class='far fa-edit'></i>
                </button>
                <button class='btn btn-outline-danger baja' 
                    name='{$proveedor['id']}' title='Dar de baja'> <i class='fas fa-trash'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-info datos' 
                    title='Ver información básica'> <i class='fas fa-info-circle'></i>
                </button>
                <button class='btn btn-outline-success alta' 
                    name='{$proveedor['id']}' title='Dar de alta'> <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= "
            <tr>
                <td>" . utf8_encode($proveedor['nombre']) . "</td>
                <td>" . utf8_encode($proveedor['tipo']) . "</td>
                <td>{$proveedor['telefono']}</td>
                <td>{$proveedor['correo']}</td>
                <td>" . utf8_encode($proveedor['provincia']) . "</td>
                <td style='display: none;'>" . utf8_encode($proveedor['ciudad']) . "</td>
                <td style='display: none;'>" . utf8_encode($proveedor['direccion']) . "</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbProveedores" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                        <th>Provincia</th>
                        <th style="display: none;">Ciudad</th>
                        <th style="display: none;">Dirección</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($proveedores == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($proveedores, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
