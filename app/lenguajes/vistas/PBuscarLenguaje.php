<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorLenguaje();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $datos = ($nombre) ? "'{$nombre}', " . $estado : "TODOS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $lenguajes = $controlador->buscar($nombre, $estado);
    $_SESSION['BLENGUAJES'] = array($nombre, $estado, $datos);
} else {
    if (isset($_SESSION['BLENGUAJES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BLENGUAJES'];
        $nombre = $parametros[0];
        $estado = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $lenguajes = $controlador->buscar($nombre, $estado);
        $_SESSION['BLENGUAJES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $lenguajes = $controlador->listarUltimosCreados();
        $filtro = "Resumen inicial";
        $_SESSION['BLENGUAJES'] = NULL;
    }
}

if (gettype($lenguajes) == "resource") {
    $filas = "";
    while ($lenguaje = sqlsrv_fetch_array($lenguajes, SQLSRV_FETCH_ASSOC)) {
        if ($lenguaje['estado'] == 'Activo') {
            $operaciones = "
                <button class='btn btn-outline-warning editar' 
                        name='{$lenguaje['id']}' title='Editar'>
                    <i class='far fa-edit'></i>
                </button>
                <button class='btn btn-outline-danger baja' 
                        name='{$lenguaje['id']}' title='Dar de baja'>
                    <i class='fas fa-trash'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-success alta' 
                    name='{$lenguaje['id']}' title='Dar de alta'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= "
            <tr>
                <td>" . utf8_encode($lenguaje['nombre']) . "</td>
                <td>" . utf8_encode($lenguaje['version']) . "</td>
                <td>" . utf8_encode($lenguaje['descripcion']) . "</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbLenguajes" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Versión</th>
                        <th>Descripción</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($lenguajes == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($lenguajes, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
