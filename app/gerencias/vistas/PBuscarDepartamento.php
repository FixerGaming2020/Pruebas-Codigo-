<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorDepartamento();

if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $datos = ($nombre) ? "'{$nombre}', " . $estado : "TODOS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $departamentos = $controlador->buscar($nombre, $estado);
    $_SESSION['BDEPARTAMENTOS'] = array($nombre, $estado, $datos);
} else {
    if (isset($_SESSION['BDEPARTAMENTOS'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BDEPARTAMENTOS'];
        $nombre = $parametros[0];
        $estado = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $departamentos = $controlador->buscar($nombre, $estado);
        $_SESSION['BDEPARTAMENTOS'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $departamentos = $controlador->listarUltimosCreados();
        $filtro = "Resumen inicial";
        $_SESSION['BDEPARTAMENTOS'] = NULL;
    }
}
if (gettype($departamentos) == "resource") {
    /* SE OBTUVO UN RESULTADO DESDE LA BASE DE DATOS */
    $filas = "";
    while ($deparamento = sqlsrv_fetch_array($departamentos, SQLSRV_FETCH_ASSOC)) {
        if ($deparamento['destado'] == 'Activo') {
            $operaciones = "
                <button class='btn btn-outline-warning editar' 
                        name='{$deparamento['did']}' title='Editar'>
                    <i class='far fa-edit'></i>
                </button>
                <button class='btn btn-outline-danger baja' 
                        name='{$deparamento['did']}' title='Dar de baja'>
                    <i class='fas fa-trash'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-success alta' 
                    name='{$deparamento['did']}' title='Dar de alta'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= "
                <tr>
                    <td>" . utf8_encode($deparamento['dnombre']) . "</td>
                    <td>" . utf8_encode($deparamento['gnombre']) . "</td>
                    <td>{$deparamento['gempleado']}</td>
                    <td class='text-center'> 
                        <div class='btn-group btn-group-sm'>{$operaciones}</div>
                    </td>
                </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbDepartamentos" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Gerencia</th>
                        <th>Gerente</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($departamentos == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($departamentos, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
