<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

if ($_POST['inventario']) {
    $inventario = $_POST['inventario'];
    $controlador = new ControladorInventario();
    $auxiliares = $controlador->historicoElementoAuxiliar($inventario);
    $filtro = $inventario . ": Inventario de Elementos Auxliares";
    if (gettype($auxiliares) == "resource") {
        $filas = "";
        while ($auxiliar = sqlsrv_fetch_array($auxiliares, SQLSRV_FETCH_ASSOC)) {
            $filas .= "
            <tr>
                <td>" . utf8_encode($auxiliar['asigla']) . "</td>
                <td>" . utf8_encode($auxiliar['anombre']) . "</td>
                <td>" . utf8_encode($auxiliar['gnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($auxiliar['jid']) . "</td>
                <td>" . utf8_encode($auxiliar['jnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($auxiliar['eid']) . "</td>
                <td>" . utf8_encode($auxiliar['enombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($auxiliar['sid']) . "</td>
                <td style='display: none;'>" . utf8_encode($auxiliar['stipo']) . "</td>
                <td>" . utf8_encode($auxiliar['snombre']) . "</td> 
                <td style='display: none;'>" . utf8_encode($auxiliar['sprovincia']) . "</td>
                <td style='display: none;'>" . utf8_encode($auxiliar['sciudad']) . "</td>
                <td style='display: none;'>" . utf8_encode($auxiliar['scodigoPostal']) . "</td>
                <td style='display: none;'>" . utf8_encode($auxiliar['sdireccion']) . "</td>
                <td style='display: none;'>" . utf8_encode($auxiliar['sorigen']) . "</td>
                <td style='display: none;'>" . utf8_encode($auxiliar['acantidad']) . "</td>
                <td style='display: none;'>" . utf8_encode($auxiliar['adescripcion']) . "</td>
                <td style='display: none;'>" . utf8_encode($auxiliar['arti']) . "</td>
                <td style='display: none;'>" . utf8_encode($auxiliar['aestado']) . "</td>
            </tr>";
        }
        $cuerpo = '
        <div class="table-responsive">
            <table id="tbHistoricos" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre corto</th>
                        <th>Nombre largo</th>
                        <th>Gerencia</th>
                        <th style="display: none;">Legajo gerente</th>
                        <th>Nombre gerente</th>
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
                        <th style="display: none;">Cantidad</th>
                        <th style="display: none;">Descripción</th>
                        <th style="display: none;">RTI</th>
                        <th style="display: none;">Estado</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
    } else {
        $mensaje = $controlador->getMensaje();
        $cuerpo = ControladorHTML::getAlertaOperacion($auxiliares, $mensaje);
    }
} else {
    $filtro = "Inventario de Elementos Auxiliares";
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;

