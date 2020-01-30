<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorFirewall();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $datos = ($nombre) ? "'{$nombre}', " . $estado : "TODOS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $firewalls = $controlador->buscar($nombre, $estado);
    $_SESSION['BFIREWALLS'] = array($nombre, $estado, $datos);
} else {
    if (isset($_SESSION['BFIREWALLS'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BFIREWALLS'];
        $nombre = $parametros[0];
        $estado = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $firewalls = $controlador->buscar($nombre, $estado);
        $_SESSION['BFIREWALLS'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $firewalls = $controlador->listarUltimosCreados();
        $filtro = "Resumen inicial";
        $_SESSION['BFIREWALLS'] = NULL;
    }
}

if (gettype($firewalls) == "resource") {
    /* SE OBTUVO UN RESULTADO DESDE LA BASE DE DATOS */
    $filas = "";
    while ($firewall = sqlsrv_fetch_array($firewalls, SQLSRV_FETCH_ASSOC)) {
        if ($firewall['festado'] == 'Activo') {
            $operaciones = "
                <button class='btn btn-outline-info datos' 
                        name='{$firewall['fid']}' title='Ver información básica'>
                    <i class='fas fa-info-circle'></i>
                </button>
                <button class='btn btn-outline-warning editar' 
                        name='{$firewall['fid']}' title='Editar'>
                    <i class='far fa-edit'></i>
                </button>
                <button class='btn btn-outline-danger baja' 
                        name='{$firewall['fid']}' title='Dar de baja'>
                    <i class='fas fa-trash'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-info detalle' 
                        name='{$firewall['fid']}' title='Ver detalle'>
                    <i class='fas fa-eye'></i>
                </button>
                <button class='btn btn-outline-success alta' 
                    name='{$firewall['fid']}' title='Dar de alta'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= "
            <tr>
                <td>" . utf8_encode($firewall['fnombre']) . "</td>
                <td>" . utf8_encode($firewall['fmarca']) . "</td>
                <td>" . utf8_encode($firewall['fmodelo']) . "</td> 
                <td>" . utf8_encode($firewall['fnumeroSerie']) . "</td>
                <td style='display: none;'>" . utf8_encode($firewall['fversion']) . "</td>
                <td style='display: none;'>{$firewall['fip']}</td>
                <td>" . utf8_encode($firewall['snombre']) . "</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbFirewalls" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Nro serie</th>
                        <th style="display: none;">Versión</th>
                        <th style="display: none;">IP</th>
                        <th>Sucursal</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($firewalls == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($firewalls, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
