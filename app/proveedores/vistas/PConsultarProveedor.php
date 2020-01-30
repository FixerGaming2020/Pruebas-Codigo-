<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();

$controlador = new ControladorProveedor();
session_start();

if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $provincia = $_POST['provincia'];
    $datos = ($nombre) ? "'{$nombre}', " : "TODOS, ";
    $datos .= ($provincia) ? "'{$provincia}'" : "TODAS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $proveedores = $controlador->consultar($nombre, $provincia);
    $_SESSION['CPROVEEDORES'] = array($nombre, $provincia, $datos);
} else {
    if (isset($_SESSION['CPROVEEDORES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['CPROVEEDORES'];
        $nombre = $parametros[0];
        $provincia = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $proveedores = $controlador->consultar($nombre, $provincia);
        $_SESSION['CPROVEEDORES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $proveedores = $controlador->listarUltimosCreados();
        $filtro = "Resumen inicial";
        $_SESSION['CPROVEEDORES'] = NULL;
    }
}

if (gettype($proveedores) == "resource") {
    /* SE OBTUVO UN RESULTADO DESDE LA BASE DE DATOS */
    $filas = "";
    while ($proveedor = sqlsrv_fetch_array($proveedores, SQLSRV_FETCH_ASSOC)) {
        $filas .= "
            <tr>
                <td>" . utf8_encode($proveedor['nombre']) . "</td>
                <td>{$proveedor['telefono']}</td>
                <td>{$proveedor['correo']}</td>
                <td>" . utf8_encode($proveedor['provincia']) . "</td>
                <td>" . utf8_encode($proveedor['ciudad']) . "</td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbProveedores" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                        <th>Provincia</th>
                        <th>Ciudad</th>
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

echo ControladorHTML::getCardBusqueda($filtro, $cuerpo);
