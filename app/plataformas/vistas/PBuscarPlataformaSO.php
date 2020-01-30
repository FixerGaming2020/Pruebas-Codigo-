<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorPlataformaSO();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $datos = ($nombre) ? "'{$nombre}', " . $estado : "TODOS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $plataformas = $controlador->buscar($nombre, $estado);
    $_SESSION['BPLATAFORMAS'] = array($nombre, $estado, $datos);
} else {
    if (isset($_SESSION['BPLATAFORMAS'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BPLATAFORMAS'];
        $nombre = $parametros[0];
        $estado = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $plataformas = $controlador->buscar($nombre, $estado);
        $_SESSION['BPLATAFORMAS'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $plataformas = $controlador->listarUltimasCreadas();
        $filtro = "Resumen inicial";
        $_SESSION['BPLATAFORMAS'] = NULL;
    }
}


if (gettype($plataformas) == "resource") {
    $filas = "";
    while ($plataforma = sqlsrv_fetch_array($plataformas, SQLSRV_FETCH_ASSOC)) {
        if ($plataforma['estado'] == 'Activa') {
            $operaciones = "
                <button class='btn btn-outline-warning editar' 
                        name='{$plataforma['id']}' title='Editar'>
                    <i class='far fa-edit'></i>
                </button>
                <button class='btn btn-outline-danger baja' 
                        name='{$plataforma['id']}' title='Dar de baja'>
                    <i class='fas fa-trash'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-success alta' 
                    name='{$plataforma['id']}' title='Dar de alta'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= "
            <tr>
                <td>" . utf8_encode($plataforma['nombre']) . "</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbPlataformas" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($plataformas == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($plataformas, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
