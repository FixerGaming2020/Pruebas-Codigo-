<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

if ($_POST['inventario']) {
    $inventario = $_POST['inventario'];
    $controlador = new ControladorInventario();
    $comunicaciones = $controlador->historicoComunicacion($inventario);
    $filtro = $inventario . ": Inventario de Comunicaciones";
    if (gettype($comunicaciones) == "resource") {
        $filas = "";
        while ($comunicacion = sqlsrv_fetch_array($comunicaciones, SQLSRV_FETCH_ASSOC)) {
            $filas .= "
            <tr>
                <td>" . utf8_encode($comunicacion['csigla']) . "</td>
                <td>" . utf8_encode($comunicacion['cnombre']) . "</td>
                <td>" . utf8_encode($comunicacion['gnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['jid']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['jnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['eid']) . "</td>
                <td>" . utf8_encode($comunicacion['enombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['sid']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['stipo']) . "</td>
                <td>" . utf8_encode($comunicacion['snombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['sprovincia']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['sciudad']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['scodigoPostal']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['sdireccion']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['sorigen']) . "</td>
                <td>" . utf8_encode($comunicacion['pnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['ptelefono']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['pcorreo']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['pprovincia']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['pciudad']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['pdireccion']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['ptipo']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['ccantidad']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['cdescripcion']) . "</td>
                <td style='display: none;'>" . utf8_encode($comunicacion['crti']) . "</td>
            </tr>";
        }
        $cuerpo = '
        <div class="table-responsive">
            <table id="tbHistoricos" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Sigla</th>
                        <th>Nombre largo</th>
                        <th>Gerencia</th>
                        <th style="display: none;">Legajo gerente</th>
                        <th style="display: none;">Nombre gerente</th>
                        <th style="display: none;">Legajo delegado</th>
                        <th>Nombre delegado</th>
                        <th style="display: none;">Código sitio</th>
                        <th style="display: none;">Tipo sitio</th>
                        <th>Nombre sitio</th>
                        <th style="display: none;">Provincia sitio</th>
                        <th style="display: none;">Ciudad sitio</th>
                        <th style="display: none;">Código postal sitio</th>
                        <th style="display: none;">Dirección sitio</th>
                        <th style="display: none;">Origen sitio</th>
                        <th>Nombre proveedor</th>
                        <th style="display: none;">Telefono proveedor</th>
                        <th style="display: none;">Correo proveedor</th>
                        <th style="display: none;">Provincia proveedor</th>
                        <th style="display: none;">Ciudad proveedor</th>
                        <th style="display: none;">Direccion proveedor</th>
                        <th style="display: none;">Tipo proveedor</th>
                        <th style="display: none;">Cantidad</th>
                        <th style="display: none;">Descripción</th>
                        <th style="display: none;">Riesgo TI</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
    } else {
        $mensaje = $controlador->getMensaje();
        $cuerpo = ControladorHTML::getAlertaOperacion($comunicaciones, $mensaje);
    }
} else {
    $filtro = "Inventario de Comunicaciones";
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;

