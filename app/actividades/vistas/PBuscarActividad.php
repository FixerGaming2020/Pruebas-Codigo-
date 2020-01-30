<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();

$controlador = new ControladorActividad();

if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $modulo = $_POST['modulo'];
    $operacion = $_POST['operacion'];
    $legajo = $_POST['legajo'];
    $fecha = $_POST['fecha'];
    $datos = "'{$modulo}', '{$operacion}', ";
    $datos .= ($legajo) ? "'{$legajo}', " : "TODOS, ";
    $datos .= ($fecha) ? "'{$fecha}'" : "TODAS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $actividades = $controlador->buscar($modulo, $operacion, $legajo, $fecha);
    $_SESSION['BACTIVIDADES'] = array($modulo, $operacion, $legajo, $fecha, $datos);
} else {
    if (isset($_SESSION['BACTIVIDADES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BACTIVIDADES'];
        $modulo = $parametros[0];
        $operacion = $parametros[1];
        $legajo = $parametros[2];
        $fecha = $parametros[3];
        $filtro = "Ultima búsqueda realizada: " . $parametros[4];
        $actividades = $controlador->buscar($modulo, $operacion, $legajo, $fecha);
        $_SESSION['BACTIVIDADES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $actividades = $controlador->listarUltimasCreadas();
        $filtro = "Resumen inicial";
        $_SESSION['BACTIVIDADES'] = NULL;
    }
}

if (gettype($actividades) == "resource") {
    $filas = "";
    while ($actividad = sqlsrv_fetch_array($actividades, SQLSRV_FETCH_ASSOC)) {
        $fecha = date_format($actividad['afecha'], 'd/m/Y H:m:s');
        $filas .= "
            <tr>
                <td>{$actividad['ulegajo']}</td>
                <td>" . utf8_encode($actividad['unombre']) . "</td>
                <td>{$actividad['amodulo']}</td>
                <td>{$actividad['atabla']}</td>
                <td>{$actividad['aoperacion']}</td>
                <td>{$actividad['aregistro']}</td>
                <td>{$fecha}</td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbActividades" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Legajo</th>
                        <th>Usuario</th>
                        <th>Módulo</th>
                        <th>Tabla</th>
                        <th>Operación</th>
                        <th>Registro</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($actividades == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($actividades, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
