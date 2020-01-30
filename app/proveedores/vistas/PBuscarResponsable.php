<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();

$controlador = new ControladorResponsable();
session_start();

if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $datos = ($nombre) ? "'{$nombre}', " . $estado : "TODAS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $responsables = $controlador->buscar($nombre, $estado);
    $_SESSION['BRESPONSABLES'] = array($nombre, $estado, $datos);
} else {
    if (isset($_SESSION['BRESPONSABLES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BRESPONSABLES'];
        $nombre = $parametros[0];
        $estado = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $responsables = $controlador->buscar($nombre, $estado);
        $_SESSION['BRESPONSABLES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $responsables = $controlador->listarUltimosCreados();
        $filtro = "Resumen inicial";
        $_SESSION['BRESPONSABLES'] = NULL;
    }
}

if (gettype($responsables) == "resource") {
    /* SE OBTUVO UN RESULTADO DESDE LA BASE DE DATOS */
    $filas = "";
    while ($responsable = sqlsrv_fetch_array($responsables, SQLSRV_FETCH_ASSOC)) {
        if ($responsable['restado'] == 'Activo') {
            $operaciones = "
                <button class='btn btn-outline-warning editar' 
                    name='{$responsable['rid']}' title='Editar'>
                        <i class='far fa-edit'></i>
                </button>
                <button class='btn btn-outline-danger baja' 
                    name='{$responsable['rid']}' title='Dar de baja'>
                        <i class='fas fa-trash'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-success alta' 
                    name='{$responsable['rid']}' title='Dar de alta'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= "
            <tr>
                <td>" . utf8_encode($responsable['pnombre']) . "</td>
                <td>" . utf8_encode($responsable['rnombre']) . "</td>
                <td>{$responsable['rtelefono']}</td>
                <td>{$responsable['rcorreo']}</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbResponsables" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Proveedor</th>
                        <th>Responsable</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($responsables == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($responsables, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);
echo $formulario;
