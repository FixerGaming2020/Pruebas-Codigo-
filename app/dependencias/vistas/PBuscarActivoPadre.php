<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorActivoPadre();

if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $datos = ($nombre) ? "'{$nombre}', " . $estado : "TODOS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $padres = $controlador->buscar($nombre, $estado);
    $_SESSION['BAHIJOS'] = array($nombre, $estado, $datos);
} else {
    if (isset($_SESSION['BAPADRES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BAPADRES'];
        $nombre = $parametros[0];
        $estado = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $padres = $controlador->buscar($nombre, $estado);
        $_SESSION['BAPADRES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $padres = $controlador->listarUltimosCreados();
        $filtro = "Resumen inicial";
        $_SESSION['BAPADRES'] = NULL;
    }
}


if (gettype($padres) == "resource") {
    /* SE OBTUVO UN RESULTADO DESDE LA BASE DE DATOS */
    $filas = "";
    while ($padre = sqlsrv_fetch_array($padres, SQLSRV_FETCH_ASSOC)) {
        if ($padre['estado'] == 'Activo') {
            $operaciones = "
                <button class='btn btn-outline-warning editar' 
                        name='{$padre['id']}' title='Editar'>
                    <i class='far fa-edit'></i>
                </button>
                <button class='btn btn-outline-danger baja' 
                        name='{$padre['id']}' title='Dar de baja'>
                    <i class='fas fa-trash'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-success alta' 
                    name='{$padre['id']}' title='Dar de alta'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= "
            <tr>
                <td>" . utf8_encode($padre['categoria']) . "</td>
                <td>" . utf8_encode($padre['sigla']) . "</td>
                <td>" . utf8_encode($padre['nombre']) . "</td>
                <td>" . utf8_encode($padre['hijos']) . "</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbActivosHijos" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Nombre corto</th>
                        <th>Nombre largo</th>
                        <th>Hijos</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($padres == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($padres, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;

