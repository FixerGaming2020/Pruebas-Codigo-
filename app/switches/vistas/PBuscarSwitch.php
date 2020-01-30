<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorSwitch();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $datos = ($nombre) ? "'{$nombre}', " . $estado : "TODOS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $switchs = $controlador->buscar($nombre, $estado);
    $_SESSION['BSWITCHS'] = array($nombre, $estado, $datos);
} else {
    if (isset($_SESSION['BSWITCHS'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BSWITCHS'];
        $nombre = $parametros[0];
        $estado = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $switchs = $controlador->buscar($nombre, $estado);
        $_SESSION['BSWITCHS'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $switchs = $controlador->listarUltimosCreados();
        $filtro = "Resumen inicial";
        $_SESSION['BSWITCHS'] = NULL;
    }
}

if (gettype($switchs) == "resource") {
    $filas = "";
    while ($switch = sqlsrv_fetch_array($switchs, SQLSRV_FETCH_ASSOC)) {
        if ($switch['sestado'] == 'Activo') {
            $operaciones = "
                <button class='btn btn-outline-warning editar' 
                        name='{$switch['sid']}' title='Editar'>
                    <i class='far fa-edit'></i>
                </button>
                <button class='btn btn-outline-danger baja' 
                        name='{$switch['sid']}' title='Dar de baja'>
                    <i class='fas fa-trash'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-success alta' 
                    name='{$switch['sid']}' title='Dar de alta'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= "
            <tr>
                <td>" . utf8_encode($switch['snombre']) . "</td>
                <td>" . utf8_encode($switch['smodelo']) . "</td>
                <td>" . utf8_encode($switch['sversion']) . "</td>
                <td>" . utf8_encode($switch['inombre']) . "</td> 
                <td>" . utf8_encode($switch['unombre']) . "</td> 
                <td>" . utf8_encode($switch['srti']) . "</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbSwitchs" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Modelo</th>
                        <th>Versión</th>
                        <th>Instalación</th>
                        <th>Ubicación</th>
                        <th>RTI</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($switchs == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($switchs, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
