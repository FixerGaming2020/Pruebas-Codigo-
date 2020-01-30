<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorEmpleado();

if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $datos = ($nombre) ? "'{$nombre}', " . $estado : "TODAS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $trabajadores = $controlador->buscar($nombre, $estado);
    $_SESSION['BEMPLEADOS'] = array($nombre, $estado, $datos);
} else {
    if (isset($_SESSION['BEMPLEADOS'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BEMPLEADOS'];
        $nombre = $parametros[0];
        $estado = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $trabajadores = $controlador->buscar($nombre, $estado);
        $_SESSION['BEMPLEADOS'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $trabajadores = $controlador->listarUltimosCreados();
        $filtro = "Resumen inicial";
        $_SESSION['BEMPLEADOS'] = NULL;
    }
}

if (gettype($trabajadores) == "resource") {
    /* SE OBTUVO UN RESULTADO DESDE LA BASE DE DATOS */
    $filas = "";
    while ($trabajador = sqlsrv_fetch_array($trabajadores, SQLSRV_FETCH_ASSOC)) {
        if ($trabajador['eestado'] == 'Activo') {
            $operaciones = "
                <button class='btn btn-outline-warning editar' 
                        name='{$trabajador['eid']}' title='Editar'>
                    <i class='far fa-edit'></i>
                </button>
                <button class='btn btn-outline-danger baja' 
                        name='{$trabajador['eid']}' title='Dar de baja'>
                    <i class='fas fa-trash'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-success alta' 
                    name='{$trabajador['eid']}' title='Dar de alta'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= "
                <tr>
                    <td>{$trabajador['eid']}</td>
                    <td>" . utf8_encode($trabajador['enombre']) . "</td>
                    <td>" . utf8_encode($trabajador['dnombre']) . "</td>
                    <td>{$trabajador['gerente']}</td>
                    <td class='text-center'>
                        <div class='btn-group btn-group-sm'>{$operaciones}</div>
                    </td>
                </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbEmpleados" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Legajo</th>
                        <th>Nombre</th>
                        <th>Departamento</th>
                        <th>Gerencia</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($trabajadores == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($trabajadores, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
