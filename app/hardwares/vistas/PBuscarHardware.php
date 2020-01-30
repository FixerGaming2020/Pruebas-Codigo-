<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorHardware();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $datos = ($nombre) ? "'{$nombre}', " . $estado : "TODOS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $hardwares = $controlador->buscar($nombre, $estado);
    $_SESSION['BHARDWARES'] = array($nombre, $estado, $datos);
} else {
    if (isset($_SESSION['BHARDWARES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BHARDWARES'];
        $nombre = $parametros[0];
        $estado = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $hardwares = $controlador->buscar($nombre, $estado);
        $_SESSION['BHARDWARES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $hardwares = $controlador->listarUltimosCreados();
        $filtro = "Resumen inicial";
        $_SESSION['BHARDWARES'] = NULL;
    }
}

if (gettype($hardwares) == "resource") {
    /* SE OBTUVO UN RESULTADO DESDE LA BASE DE DATOS */
    $filas = "";
    while ($hardware = sqlsrv_fetch_array($hardwares, SQLSRV_FETCH_ASSOC)) {
        if ($hardware['hestado'] == 'Activo') {
            $operaciones = "
                <button class='btn btn-outline-info datos' 
                        name='{$hardware['hid']}' title='Ver detalle'>
                        <i class='fas fa-info-circle'></i>
                </button>
                <button class='btn btn-outline-warning editar' 
                        name='{$hardware['hid']}' title='Editar'>
                    <i class='far fa-edit'></i>
                </button>
                <button class='btn btn-outline-danger baja' 
                        name='{$hardware['hid']}' title='Dar de baja'>
                    <i class='fas fa-trash'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-info datos' 
                        name='{$hardware['hid']}' title='Ver detalle'>
                        <i class='fas fa-info-circle'></i>
                </button>
                <button class='btn btn-outline-success alta' 
                    name='{$hardware['hid']}' title='Dar de alta'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= "
            <tr>
                <td>{$hardware['htipo']}</td>
                <td>{$hardware['hsigla']}</td>
                <td>{$hardware['hnombre']}</td>
                <td style='display: none;'>{$hardware['hdominio']}</td>
                <td>" . utf8_encode($hardware['hambiente']) . "</td>
                <td style='display: none;'>" . utf8_encode($hardware['hsoftwareBase']) . "</td>
                <td>" . utf8_encode($hardware['snombre']) . "</td>
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
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbHardwares" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Nombre corto</th>
                        <th>Nombre largo</th>
                        <th style="display: none;">Dominio</th>
                        <th>Ambiente</th>
                        <th style="display: none;">Software base</th>
                        <th>Sitio</th>
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
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($hardwares == 1) ? $mensaje . " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($hardwares, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
