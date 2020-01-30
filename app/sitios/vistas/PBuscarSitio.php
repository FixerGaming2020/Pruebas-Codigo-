<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorSitio();
if (isset($_POST['peticion'])) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $sitios = $controlador->buscar($nombre, $estado);
    $datos = ($nombre) ? "'{$nombre}', " . $estado : "TODOS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $_SESSION['BSITIOS'] = array($nombre, $estado, $datos);
} else {
    if (isset($_SESSION['BSITIOS'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BSITIOS'];
        $nombre = $parametros[0];
        $estado = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $sitios = $controlador->buscar($nombre, $estado);
        $_SESSION['BSITIOS'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $sitios = $controlador->listarUltimosCreados();
        $filtro = "Últimas sitios creados";
        $_SESSION['BSITIOS'] = NULL;
    }
}

if (gettype($sitios) == "resource") {
    $filas = $operaciones = "";
    while ($sitio = sqlsrv_fetch_array($sitios, SQLSRV_FETCH_ASSOC)) {
        if ($sitio['estado'] == 'Activo') {
            $operaciones = "
                <button class='btn btn-outline-info datos' 
                    name='{$sitio['id']}' title='Datos básicos'>
                    <i class='fas fa-info-circle'></i>
                </button>
                <button class='btn btn-outline-warning editar' 
                    name='{$sitio['id']}' title='Editar'>
                    <i class='far fa-edit'></i>
                </button>

                <button class='btn btn-outline-danger baja' 
                    name='{$sitio['id']}' title='Dar de baja'>
                    <i class='fas fa-trash'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-info datos' 
                    name='{$sitio['id']}' title='Datos básicos'>
                    <i class='fas fa-info-circle'></i>
                </button>
                <button class='btn btn-outline-success alta' 
                    name='{$sitio['id']}' title='Dar de alta'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= "
            <tr>
                <td class='align-middle'>{$sitio['id']}</td>
                <td class='align-middle'>{$sitio['tipo']}</td>
                <td class='align-middle'>" . utf8_encode($sitio['nombre']) . "</td>
                <td class='align-middle'>" . utf8_encode($sitio['provincia']) . "</td>
                <td class='align-middle'>" . utf8_encode($sitio['ciudad']) . "</td>
                <td style='display: none;' class='align-middle'>{$sitio['codigoPostal']}</td>
                <td style='display: none;' class='align-middle'>" . utf8_encode($sitio['direccion']) . "</td>
                <td class='align-middle'>{$sitio['origen']}</td>
                <td class='text-center align-middle'>
                    <div class='btn-group btn-group-sm'>
                        {$operaciones}
                    </div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbSitios" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Tipo</th>
                        <th>Nombre</th>
                        <th>Provincia</th>
                        <th>Ciudad</th>
                        <th style="display: none;">Código postal</th>
                        <th style="display: none;">Dirección</th>
                        <th>Origen</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($sitios == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($sitios, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);
echo $formulario;
