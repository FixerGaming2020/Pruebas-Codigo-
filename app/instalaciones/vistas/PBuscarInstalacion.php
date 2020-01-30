<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorInstalacion();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $datos = ($nombre) ? "'{$nombre}', " . $estado : "TODAS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $instalaciones = $controlador->buscar($nombre, $estado);
    $_SESSION['BINSTALACIONES'] = array($nombre, $estado, $datos);
} else {
    if (isset($_SESSION['BINSTALACIONES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BINSTALACIONES'];
        $nombre = $parametros[0];
        $estado = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $instalaciones = $controlador->buscar($nombre, $estado);
        $_SESSION['BINSTALACIONES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $instalaciones = $controlador->listarUltimasCreadas();
        $filtro = "Resumen inicial";
        $_SESSION['BINSTALACIONES'] = NULL;
    }
}

if (gettype($instalaciones) == "resource") {
    $filas = "";
    while ($instalacion = sqlsrv_fetch_array($instalaciones, SQLSRV_FETCH_ASSOC)) {
        if ($instalacion['iestado'] == 'Activa') {
            $operaciones = "
                <button class='btn btn-outline-info datos' 
                        name='{$instalacion['iid']}' title='Datos básicos'>
                        <i class='fas fa-info-circle'></i>
                </button>
                <button class='btn btn-outline-warning editar' 
                        name='{$instalacion['iid']}' title='Editar'>
                    <i class='far fa-edit'></i>
                </button>
                <button class='btn btn-outline-danger baja' 
                        name='{$instalacion['iid']}' title='Dar de baja'>
                    <i class='fas fa-trash'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-success alta' 
                    name='{$instalacion['iid']}' title='Dar de alta'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= "
            <tr>
                <td>" . utf8_encode($instalacion['isigla']) . "</td>
                <td>" . utf8_encode($instalacion['inombre']) . "</td>
                <td>" . utf8_encode($instalacion['gnombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($instalacion['eid']) . "</td> 
                <td>" . utf8_encode($instalacion['enombre']) . "</td> 
                <td style='display: none;'>" . utf8_encode($instalacion['sid']) . "</td> 
                <td>" . utf8_encode($instalacion['snombre']) . "</td>
                <td style='display: none;'>" . utf8_encode($instalacion['pnombre']) . "</td> 
                <td style='display: none;'>{$instalacion['irti']}</td> 
                <td style='display: none;'>" . utf8_encode($instalacion['idescripcion']) . "</td> 
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbInstalaciones" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre corto</th>
                        <th>Nombre largo</th>
                        <th>Gerencia</th>
                        <th style="display: none;">Legajo</th>
                        <th>Responsable</th>
                        <th style="display: none;">Código</th>
                        <th>Ubicación</th>
                        <th style="display: none;">Plataforma</th>
                        <th style="display: none;">RTI</th>
                        <th style="display: none;">Descripcion</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($instalaciones == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($instalaciones, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
