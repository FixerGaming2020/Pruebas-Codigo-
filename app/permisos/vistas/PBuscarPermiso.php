<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorPermiso();

if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $nivel = $_POST['nivel'];
    $permisos = $controlador->buscar($nombre, $nivel);
    $filtro = "Resultado de la búsqueda: ";
    $filtro .= ($nombre) ? $nombre . ", " . $nivel : "TODOS, " . $nivel;
    $_SESSION['BPERMISOS'] = array($nombre, $nivel);
} else {
    if (isset($_SESSION['BPERMISOS'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BPERMISOS'];
        $nombre = $parametros[0];
        $nivel = $parametros[1];
        $permisos = $controlador->buscar($nombre, $nivel);
        $filtro = "Ultima búsqueda realizada: ";
        $filtro .= ($nombre) ? $nombre . ", " . $nivel : $nivel;
        $_SESSION['BPERMISOS'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $permisos = $controlador->listarUltimosCreados();
        $filtro = "Ultimos permisos creados y en estado activo";
        $_SESSION['BPERMISOS'] = NULL;
    }
}

if (gettype($permisos) == "resource") {
    $filas = "";
    while ($permiso = sqlsrv_fetch_array($permisos, SQLSRV_FETCH_ASSOC)) {
        if (($permiso['perfiles'] == 0) && ($permiso['hijos'] == 0)) {
            $operaciones = "
                <button class='btn btn-outline-warning editar' 
                    name='{$permiso['id']}' title='Editar'>
                    <i class='far fa-edit'></i></button>
                <button class='btn btn-outline-danger baja'
                    name='{$permiso['id']}' title='Borrar'>
                    <i class='fas fa-trash'></i></button>";
        } else {
            $operaciones = "<button class='btn btn-outline-warning editar' "
                    . "name='{$permiso['id']}' title='Editar'>"
                    . "<i class='far fa-edit'></i></button>";
        }
        $filas .= "
            <tr>
                <td>" . utf8_encode($permiso['titulo']) . "</td>
                <td>" . utf8_encode($permiso['padre']) . "</td>
                <td>{$permiso['link']}</td>
                <td>{$permiso['perfiles']}</td>
                <td>{$permiso['hijos']}</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbPermisos" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Titulo</th>
                        <th>Padre</th>
                        <th>Link</th>
                        <th>Roles</th>
                        <th>Permisos</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($permisos == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($permisos, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
