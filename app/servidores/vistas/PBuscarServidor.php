<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorServidor();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $estado = $_POST['estado'];
    $servidores = $controlador->buscar($nombre, $tipo, $estado);
    $datos = ($nombre) ? "'{$nombre}', " : "TODOS, ";
    $datos .= ($tipo) ? "'{$tipo}', " . $estado : "TODOS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $_SESSION['BSERVIDORES'] = array($nombre, $tipo, $estado, $datos);
} else {
    if (isset($_SESSION['BSERVIDORES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BSERVIDORES'];
        $nombre = $parametros[0];
        $tipo = $parametros[1];
        $estado = $parametros[2];
        $servidores = $controlador->buscar($nombre, $tipo, $estado);
        $filtro = "Ultima búsqueda realizada: " . $parametros[3];
        $_SESSION['BSERVIDORES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $servidores = $controlador->listarUltimosCreados();
        $filtro = "Resumen inicial";
        $_SESSION['BSERVIDORES'] = NULL;
    }
}

if (gettype($servidores) == "resource") {
    $filas = "";
    while ($servidor = sqlsrv_fetch_array($servidores, SQLSRV_FETCH_ASSOC)) {
        if ($servidor['estado'] == "Activo") {
            $operaciones = "
                <button class='btn btn-outline-info datos' 
                        name='{$servidor['id']}' title='Ver detalle'>
                        <i class='fas fa-info-circle'></i>
                </button>
                <button class='btn btn-outline-warning editar' 
                    name='{$servidor['id']}' title='Editar'>
                    <i class='far fa-edit'></i></button>
                <button class='btn btn-outline-danger baja' 
                    name='{$servidor['id']}' title='Borrar'>
                    <i class='fas fa-trash'></i></button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-info datos' 
                        name='{$servidor['id']}' title='Ver detalle'>
                        <i class='fas fa-info-circle'></i>
                </button>
                <button class='btn btn-outline-success alta' 
                    name='{$servidor['id']}' title='Dar de alta'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= "
            <tr>
                <td>" . utf8_encode($servidor['id']) . "</td>
                <td>" . utf8_encode($servidor['nombre']) . "</td>
                <td>" . utf8_encode($servidor['ambiente']) . "</td>
                <td>" . utf8_encode($servidor['tipo']) . "</td>
                <td style='display: none;'>" . utf8_encode($servidor['descripcion']) . "</td> 
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        {$operaciones}
                    </div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbServidores" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>IP</th>
                        <th>Nombre</th>
                        <th>Ambiente</th>
                        <th>Tipo</th>
                        <th style="display: none;">Descripción</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($servidores == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($servidores, $mensaje);
}
$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
