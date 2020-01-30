<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorPerfil();

if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $datos = ($nombre) ? "'{$nombre}', " . $estado : "TODOS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $perfiles = $controlador->buscar($nombre, $estado);
    $_SESSION['BPERFIL'] = array($nombre, $estado, $datos);
} else {
    if (isset($_SESSION['BPERFIL'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BPERFIL'];
        $nombre = $parametros[0];
        $nivel = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $perfiles = $controlador->buscar($nombre, $nivel);
        $_SESSION['BPERFIL'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $perfiles = $controlador->listarUltimosCreados();
        $filtro = "Resumen inicial de perfiles";
        $_SESSION['BPERFIL'] = NULL;
    }
}

if (gettype($perfiles) == "resource") {
    $filas = "";
    while ($perfil = sqlsrv_fetch_array($perfiles, SQLSRV_FETCH_ASSOC)) {
        if ($perfil['usuarios'] > 0 && $perfil['estado'] == 'Activo') {
            $operaciones = "<button class='btn btn-outline-warning editar' 
                    name='{$perfil['id']}' title='Editar'>
                    <i class='far fa-edit'></i></button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-warning editar' 
                    name='{$perfil['id']}' title='Editar'>
                    <i class='far fa-edit'></i></button>
                <button class='btn btn-outline-danger baja' 
                    name='{$perfil['id']}' title='Borrar'>
                    <i class='fas fa-trash'></i></button>";
        }
        $filas .= "
            <tr>
                <td>" . utf8_encode($perfil['nombre']) . "</td>
                <td>" . utf8_encode($perfil['descripcion']) . "</td>
                <td>{$perfil['usuarios']}</td>
                <td>{$perfil['permisos']}</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbPerfiles" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th title="Cantidad de usuarios asociados">Usuarios</th>
                        <th title="Cantidad de permisos asociados">Permisos</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($perfiles == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($perfiles, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
