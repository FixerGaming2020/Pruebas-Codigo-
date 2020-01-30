<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorHerramientaDesarrollo();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $datos = ($nombre) ? "'{$nombre}', " . $estado : "TODOS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $herramientas = $controlador->buscar($nombre, $estado);
    $_SESSION['BHERRAMIENTAS'] = array($nombre, $estado, $datos);
} else {
    if (isset($_SESSION['BHERRAMIENTAS'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BHERRAMIENTAS'];
        $nombre = $parametros[0];
        $estado = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $herramientas = $controlador->buscar($nombre, $estado);
        $_SESSION['BHERRAMIENTAS'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $herramientas = $controlador->listarUltimasCreadas();
        $filtro = "Resumen inicial";
        $_SESSION['BHERRAMIENTAS'] = NULL;
    }
}

if (gettype($herramientas) == "resource") {
    $filas = "";
    while ($herramienta = sqlsrv_fetch_array($herramientas, SQLSRV_FETCH_ASSOC)) {
        if ($herramienta['estado'] == 'Activa') {
            $operaciones = "
                <button class='btn btn-outline-warning editar' 
                        name='{$herramienta['id']}' title='Editar'>
                    <i class='far fa-edit'></i>
                </button>
                <button class='btn btn-outline-danger baja' 
                        name='{$herramienta['id']}' title='Dar de baja'>
                    <i class='fas fa-trash'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-success alta' 
                    name='{$herramienta['id']}' title='Dar de alta'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= "
            <tr>
                <td>" . utf8_encode($herramienta['nombre']) . "</td>
                <td>" . utf8_encode($herramienta['version']) . "</td>
                <td>" . utf8_encode($herramienta['fabricante']) . "</td>
                <td>" . utf8_encode($herramienta['descripcion']) . "</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbHerramientas" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Versión</th>
                        <th>Fabricante</th>
                        <th>Descripción</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($herramientas == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($herramientas, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
