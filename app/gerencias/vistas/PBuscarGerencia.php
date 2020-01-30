<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorGerencia();

if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $datos = ($nombre) ? "'{$nombre}', " . $estado : "TODAS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $gerencias = $controlador->buscar($nombre, $estado);
    $_SESSION['BGERENCIAS'] = array($nombre, $estado, $datos);
} else {
    if (isset($_SESSION['BGERENCIAS'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BGERENCIAS'];
        $nombre = $parametros[0];
        $estado = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $gerencias = $controlador->buscar($nombre, $estado);
        $_SESSION['BGERENCIAS'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $gerencias = $controlador->listarUltimasCreadas();
        $filtro = "Resumen inicial";
        $_SESSION['BGERENCIAS'] = NULL;
    }
}

if (gettype($gerencias) == "resource") {
    /* SE OBTUVO UN RESULTADO DESDE LA BASE DE DATOS */
    $filas = "";
    while ($gerencia = sqlsrv_fetch_array($gerencias, SQLSRV_FETCH_ASSOC)) {
        if ($gerencia['gestado'] == 'Activa') {
            $operaciones = "
                <button class='btn btn-outline-warning editar' 
                        name='{$gerencia['gid']}' title='Editar'>
                    <i class='far fa-edit'></i>
                </button>
                <button class='btn btn-outline-danger baja' 
                        name='{$gerencia['gid']}' title='Dar de baja'>
                    <i class='fas fa-trash'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-success alta' 
                    name='{$gerencia['gid']}' title='Dar de alta'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= "
            <tr>
                <td>" . utf8_encode($gerencia['gnombre']) . "</td>
                <td>" . utf8_encode($gerencia['eid']) . "</td>
                <td>" . utf8_encode($gerencia['enombre']) . "</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbGerencias" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Legajo</th>
                        <th>Jefe</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($gerencias == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($gerencias, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
