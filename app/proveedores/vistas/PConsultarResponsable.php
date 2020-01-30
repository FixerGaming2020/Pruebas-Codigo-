<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();

$controlador = new ControladorResponsable();
session_start();

if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $proveedor = $_POST['proveedor'];
    $datos = ($nombre) ? "'{$nombre}', " : "TODOS, ";
    $datos .= ($proveedor) ? "'{$proveedor}'" : "TODOS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $responsables = $controlador->consultar($nombre, $proveedor);
    $_SESSION['CRESPONSABLES'] = array($nombre, $proveedor, $datos);
} else {
    if (isset($_SESSION['CRESPONSABLES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['CRESPONSABLES'];
        $nombre = $parametros[0];
        $proveedor = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $responsables = $controlador->consultar($nombre, $proveedor);
        $_SESSION['CRESPONSABLES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $responsables = $controlador->listarUltimosCreados();
        $filtro = "Resumen inicial";
        $_SESSION['CRESPONSABLES'] = NULL;
    }
}

if (gettype($responsables) == "resource") {
    /* SE OBTUVO UN RESULTADO DESDE LA BASE DE DATOS */
    $filas = "";
    while ($responsable = sqlsrv_fetch_array($responsables, SQLSRV_FETCH_ASSOC)) {
       $filas .= "
            <tr>
                <td>" . utf8_encode($responsable['pnombre']) . "</td>
                <td>" . utf8_encode($responsable['rnombre']) . "</td>
                <td>{$responsable['rtelefono']}</td>
                <td>{$responsable['rcorreo']}</td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbResponsables" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Proveedor</th>
                        <th>Responsable</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($responsables == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($responsables, $mensaje);
}

echo ControladorHTML::getCardBusqueda($filtro, $cuerpo);
