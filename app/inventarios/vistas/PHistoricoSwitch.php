<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

if ($_POST['inventario']) {
    $inventario = $_POST['inventario'];
    $controlador = new ControladorInventario();
    $switchs = $controlador->historicoSwitch($inventario);
    $filtro = $inventario . ": Inventario de Switchs";
    if (gettype($switchs) == "resource") {
        $filas = "";
        while ($switch = sqlsrv_fetch_array($switchs, SQLSRV_FETCH_ASSOC)) {
            $filas .= "
            <tr>
                <td>" . utf8_encode($switch['snombre']) . "</td>
                <td>" . utf8_encode($switch['smodelo']) . "</td>
                <td>" . utf8_encode($switch['sversion']) . "</td>
                <td style='display: none;'>" . utf8_encode($switch['isigla']) . "</td> 
                <td>" . utf8_encode($switch['inombre']) . "</td> 
                <td style='display: none;'>" . utf8_encode($switch['uid']) . "</td> 
                <td>" . utf8_encode($switch['utipo']) . "</td> 
                <td>" . utf8_encode($switch['unombre']) . "</td> 
                <td style='display: none;'>" . utf8_encode($switch['uprovincia']) . "</td> 
                <td style='display: none;'>" . utf8_encode($switch['uciudad']) . "</td>
                <td style='display: none;'>" . utf8_encode($switch['ucodigoPostal']) . "</td>
                <td style='display: none;'>" . utf8_encode($switch['udireccion']) . "</td> 
                <td style='display: none;'>" . utf8_encode($switch['uorigen']) . "</td> 
                <td>" . utf8_encode($switch['srti']) . "</td>
            </tr>";
        }
        $cuerpo = '
        <div class="table-responsive">
            <table id="tbHistoricos" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Modelo</th>
                        <th>Versión</th>
                        <th style="display: none;">Sigla instalación</th>
                        <th>Nombre instalación</th>
                        <th style="display: none;">Código sitio</th>
                        <th>Tipo sitio</th>
                        <th>Nombre sitio</th>
                        <th style="display: none;">Provincia sitio</th>
                        <th style="display: none;">Ciudad sitio</th>
                        <th style="display: none;">Código postal sitio</th>
                        <th style="display: none;">Dirección sitio</th>
                        <th style="display: none;">Origen sitio</th>
                        <th>Riesgo TI</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
    } else {
        $mensaje = $controlador->getMensaje();
        $cuerpo = ControladorHTML::getAlertaOperacion($switchs, $mensaje);
    }
} else {
    $filtro = "Inventario de Switchs";
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
