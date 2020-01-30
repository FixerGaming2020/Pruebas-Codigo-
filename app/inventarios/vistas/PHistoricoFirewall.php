<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

if ($_POST['inventario']) {
    $inventario = $_POST['inventario'];
    $controlador = new ControladorInventario();
    $firewalls = $controlador->historicoFirewall($inventario);
    $filtro = $inventario . ": Inventario de Firewalls";
    if (gettype($firewalls) == "resource") {
        /* SE OBTUVO UN RESULTADO DESDE LA BASE DE DATOS */
        $filas = "";
        while ($firewall = sqlsrv_fetch_array($firewalls, SQLSRV_FETCH_ASSOC)) {
            $filas .= "
            <tr>
                <td>" . utf8_encode($firewall['fnombre']) . "</td>
                <td>" . utf8_encode($firewall['fmarca']) . "</td>
                <td>" . utf8_encode($firewall['fmodelo']) . "</td> 
                <td>" . utf8_encode($firewall['fnumeroSerie']) . "</td>
                <td>" . utf8_encode($firewall['fversion']) . "</td>
                <td>{$firewall['fip']}</td>
                <td>" . utf8_encode($firewall['snombre']) . "</td>
            </tr>";
        }
        $cuerpo = '
        <div class="table-responsive">
            <table id="tbHistoricos" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Nro serie</th>
                        <th>Versión</th>
                        <th>IP</th>
                        <th>Sucursal</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
    } else {
        $mensaje = $controlador->getMensaje();
        $cuerpo = ControladorHTML::getAlertaOperacion($firewalls, $mensaje);
    }
} else {
    $filtro = "Inventario de Firewalls";
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
