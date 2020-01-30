<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

if ($_POST['inventario']) {
    $inventario = $_POST['inventario'];
    $controlador = new ControladorInventario();
    $hardwares = $controlador->historicoHardware($inventario);
    $filtro = $inventario . ": Inventario de Hardware";
    if (gettype($hardwares) == "resource") {
        $filas = "";
        while ($hardware = sqlsrv_fetch_array($hardwares, SQLSRV_FETCH_ASSOC)) {
            $filas .= "
            <tr>
                <td>{$hardware['htipo']}</td>
                <td>{$hardware['hsigla']}</td>
                <td>{$hardware['hnombre']}</td>
                <td style='display: none;'>{$hardware['hdominio']}</td>
                <td>" . utf8_encode($hardware['hambiente']) . "</td>
                <td style='display: none;'>" . utf8_encode($hardware['hsoftwareBase']) . "</td>
                <td style='display: none;'>" . utf8_encode($hardware['sid']) . "</td>
                <td style='display: none;'>" . utf8_encode($hardware['stipo']) . "</td>
                <td>" . utf8_encode($hardware['snombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($hardware['sprovincia']) . "</td>
                <td style='display: none;'>" . utf8_encode($hardware['sciudad']) . "</td>
                <td style='display: none;'>" . utf8_encode($hardware['scodigoPostal']) . "</td>
                <td style='display: none;'>" . utf8_encode($hardware['sdireccion']) . "</td>
                <td style='display: none;'>" . utf8_encode($hardware['sorigen']) . "</td>
                <td style='display: none;'>" . utf8_encode($hardware['hsoftwareBase']) . "</td>
                <td style='display: none;'>" . utf8_encode($hardware['hsoftwareBase']) . "</td>
                <td>" . utf8_encode($hardware['hmarca']) . "</td>
                <td style='display: none;'>" . utf8_encode($hardware['hmodelo']) . "</td>
                <td style='display: none;'>" . utf8_encode($hardware['harquitectura']) . "</td>
                <td style='display: none;'>" . utf8_encode($hardware['hcore']) . "</td>
                <td style='display: none;'>" . utf8_encode($hardware['hprocesador']) . "</td>
                <td style='display: none;'>{$hardware['hmhz']}</td>
                <td style='display: none;'>{$hardware['hmemoria']}</td>
                <td style='display: none;'>" . utf8_encode($hardware['hdisco']) . "</td>
                <td style='display: none;'>" . utf8_encode($hardware['hraid']) . "</td>
                <td style='display: none;'>{$hardware['hred']}</td> 
                <td style='display: none;'>{$hardware['hrti']}</td> 
                <td style='display: none;'>" . utf8_encode($hardware['hfuncion']) . "</td> 
                <td style='display: none;'>" . utf8_encode($hardware['hestado']) . "</td> 
            </tr>";
        }
        $cuerpo = '
        <div class="table-responsive">
            <table id="tbHistoricos" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Nombre corto</th>
                        <th>Nombre largo</th>
                        <th style="display: none;">Dominio</th>
                        <th>Ambiente</th>
                        <th style="display: none;">Software base</th>
                        <th style="display: none;">Código sitio</th>
                        <th style="display: none;">Tipo sitio</th>
                        <th>Nombre sitio</th>
                        <th style="display: none;">Provincia sitio</th>
                        <th style="display: none;">Ciudad sitio</th>
                        <th style="display: none;">Código postal sitio</th>
                        <th style="display: none;">Dirección sitio</th>
                        <th style="display: none;">Origen sitio</th>
                        <th>Marca</th>
                        <th style="display: none;">Modelo</th>
                        <th style="display: none;">Arquitectura</th>
                        <th style="display: none;">Core</th>
                        <th style="display: none;">Procesador</th>
                        <th style="display: none;">Mhz</th>
                        <th style="display: none;">Memoria</th>
                        <th style="display: none;">Disco</th>
                        <th style="display: none;">Raid</th>
                        <th style="display: none;">Red</th>
                        <th style="display: none;">RTI</th>
                        <th style="display: none;">Funcion</th>
                        <th style="display: none;">Estado</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
    } else {
        $mensaje = $controlador->getMensaje();
        $cuerpo = ControladorHTML::getAlertaOperacion($hardwares, $mensaje);
    }
} else {
    $filtro = "Inventario de Hardware";
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;

