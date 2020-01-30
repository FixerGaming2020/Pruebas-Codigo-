<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorUsuario();

if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $datos = ($nombre) ? "'{$nombre}', " . $estado : "TODOS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $usuarios = $controlador->buscar($nombre, $estado);
    $_SESSION['BUSUARIOS'] = array($nombre, $estado, $datos);
} else {
    if (isset($_SESSION['BUSUARIOS'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSUARIOS'];
        $nombre = $parametros[0];
        $estado = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $usuarios = $controlador->buscar($nombre, $estado);
        $_SESSION['BUSUARIOS'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $usuarios = $controlador->listarUltimos();
        $filtro = "Resumen inicial de usuarios";
        $_SESSION['BUSUARIOS'] = NULL;
    }
}

if (gettype($usuarios) == "resource") {
    /* SE OBTUVO UN RESULTADO DESDE LA BASE DE DATOS */
    $filas = "";
    while ($usuario = sqlsrv_fetch_array($usuarios, SQLSRV_FETCH_ASSOC)) {
        if ($usuario['usuEstado'] == 'Activo') {
            $operaciones = "
                <button class='btn btn-outline-warning editar' 
                        name='{$usuario['usuId']}' title='Editar'>
                    <i class='far fa-edit'></i>
                </button>
                <button class='btn btn-outline-danger baja' 
                        name='{$usuario['usuId']}' title='Dar de baja'>
                    <i class='fas fa-trash'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-success alta' 
                    name='{$usuario['usuId']}' title='Dar de alta'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= "
            <tr>
                <td>{$usuario['usuId']}</td>
                <td>" . utf8_encode($usuario['usuNombre']) . "</td>
                <td>{$usuario['usuEstado']}</td>
                <td>{$usuario['perNombre']}</td>  
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbUsuarios" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Legajo</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Perfil</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($usuarios == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($usuarios, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
