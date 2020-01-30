<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

if ($_POST['inventario']) {
    $inventario = $_POST['inventario'];
    $controlador = new ControladorInventario();
    $aplicaciones = $controlador->historicoAplicacion($inventario);
    $filtro = $inventario . ": Inventario de Aplicaciones";
    if (gettype($aplicaciones) == "resource") {
        $filas = "";
        while ($aplicacion = sqlsrv_fetch_array($aplicaciones, SQLSRV_FETCH_ASSOC)) {
            $filas .= "
            <tr>
                <td>" . utf8_encode($aplicacion['asigla']) . "</td>
                <td>" . utf8_encode($aplicacion['anombre']) . "</td>
                <td>" . utf8_encode($aplicacion['atipo']) . "</td>
                <td>" . utf8_encode($aplicacion['aseguridad']) . "</td>
                <td>" . utf8_encode($aplicacion['atecnologia']) . "</td> 
                <td style='display: none;'>" . utf8_encode($aplicacion['pnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['hnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['hversion']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['lnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['lversion']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['bnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['mnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['unombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['gnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['enombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['snombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['apuertoProduccion']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['tnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['apuertoTest']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['dnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['apuertoDesarrollo']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['confidencialidad']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['integridad']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['disponibilidad']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['criticidad']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['arti']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['adescripcion']) . "</td>
                <td style='display: none;'>" . utf8_encode($aplicacion['aestado']) . "</td>
            </tr>";
        }

        $cuerpo = '
        <div class="table-responsive">
            <table id="tbHistoricos" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre corto</th>
                        <th>Nombre largo</th>
                        <th>Tipo</th>
                        <th>Seguridad</th>
                        <th>Técnologia</th>
                        <th style="display: none;">Proveedor</th>
                        <th style="display: none;">Nombre herramienta</th>
                        <th style="display: none;">Versión herramienta</th>
                        <th style="display: none;">Nombre lenguaje</th>
                        <th style="display: none;">Versión lenguaje</th>
                        <th style="display: none;">Base de datos</th>
                        <th style="display: none;">Modo</th>
                        <th style="display: none;">Lugar</th>
                        <th style="display: none;">Gerencia</th>
                        <th style="display: none;">Delegado</th>
                        <th style="display: none;">Servidor producción</th>
                        <th style="display: none;">Puerto producción</th>
                        <th style="display: none;">Servidor test</th>
                        <th style="display: none;">Puerto test</th>
                        <th style="display: none;">Servidor desarrollo</th>
                        <th style="display: none;">Puerto desarrollo</th>
                        <th style="display: none;">Confidencialidad</th>
                        <th style="display: none;">Integridad</th>
                        <th style="display: none;">Disponibilidad</th>
                        <th style="display: none;">Criticidad</th>
                        <th style="display: none;">RTI</th>
                        <th style="display: none;">Descripción</th>
                        <th style="display: none;">Estado</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
    } else {
        $mensaje = $controlador->getMensaje();
        $cuerpo = ControladorHTML::getAlertaOperacion($aplicaciones, $mensaje);
    }
} else {
    $filtro = "Inventario de Aplicaciones";
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}
$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
