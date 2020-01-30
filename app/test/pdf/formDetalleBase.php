<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

if (isset($_POST['idBase'])) {

    $idBase = $_POST['idBase'];
    $controladorTabla = new ControladorTabla();
    $controladorProcedimiento = new ControladorProcedimiento();
    $controladorVista = new ControladorVista();

    /* SE CARGA LA INFORMACION DE LAS TABLAS QUE POSEE LA BASE */

    $tablas = $controladorTabla->listarPorBase($idBase);
    if (gettype($tablas) == "resource") {
        $filasTabla = "";
        while ($tabla = sqlsrv_fetch_array($tablas, SQLSRV_FETCH_ASSOC)) {
            $fechaCreacion = isset($tabla['fechaCreacion']) ? date_format($tabla['fechaCreacion'], 'd/m/Y') : "";
            $fechaEdicion = isset($tabla['fechaModificacion']) ? date_format($tabla['fechaModificacion'], 'd/m/Y H:i:s') : "";
            $filasTabla .= "
                <tr>
                    <td>" . utf8_encode($tabla['nombreTabla']) . "</td>
                    <td>{$fechaCreacion}</td>
                    <td>{$fechaEdicion}</td>
                </tr>";
        }
        $cuerpoTabla = '
            <table class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha creación</th>
                        <th>Fecha edición</th>
                    </tr>
                </thead>
                <tbody>' . $filasTabla . '</tbody>
            </table>';
    } else {
        $cuerpoTabla = ControladorHTML::getAlertaOperacion($tablas, $controladorTabla->getMensaje());
    }
    $filtroTabla = "Listado de tablas";
    $cardTabla = ControladorHTML::getCardBusqueda($filtroTabla, $cuerpoTabla);

    /* SE CARGA LA INFOMRACION DE LOS PROCEDIMIENTOS QUE POSEE LA BASE */

    $procedimientos = $controladorProcedimiento->listarPorBase($idBase);
    if (gettype($procedimientos) == "resource") {
        $filasProcedimiento = "";
        while ($procedimiento = sqlsrv_fetch_array($procedimientos, SQLSRV_FETCH_ASSOC)) {
            $fechaCreacion = isset($procedimiento['fechaCreacion']) ? date_format($procedimiento['fechaCreacion'], 'd/m/Y') : "";
            $fechaEdicion = isset($procedimiento['fechaModificacion']) ? date_format($procedimiento['fechaModificacion'], 'd/m/Y H:i:s') : "";
            $filasProcedimiento .= "
                <tr>
                    <td>" . utf8_encode($procedimiento['nombreSP']) . "</td>
                    <td>{$fechaCreacion}</td>
                    <td>{$fechaEdicion}</td>
                </tr>";
        }
        $cuerpoProcedimiento = '
            <table class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha creación</th>
                        <th>Fecha edición</th>
                    </tr>
                </thead>
                <tbody>' . $filasProcedimiento . '</tbody>
            </table>';
    } else {
        $cuerpoProcedimiento = ControladorHTML::getAlertaOperacion($procedimientos, $controladorProcedimiento->getMensaje());
    }
    $filtroProcedimiento = "Listado de procedimientos almacenados";
    $cardProcedimiento = ControladorHTML::getCardBusqueda($filtroProcedimiento, $cuerpoProcedimiento);

    /* SE CARGA LA INFORMACION DE LAS VISTAS QUE POSEE LA BASE */

    $vistas = $controladorVista->listarPorBase($idBase);
    if (gettype($vistas) == "resource") {
        $filasVista = "";
        while ($vista = sqlsrv_fetch_array($vistas, SQLSRV_FETCH_ASSOC)) {
            $filasVista .= "
                <tr>
                    <td>" . utf8_encode($vista['nombreVista']) . "</td>
                    <td>" . utf8_encode($vista['consulta']) . "</td>
                </tr>";
        }
        $cuerpoVista = '
            <table class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo consulta</th>
                    </tr>
                </thead>
                <tbody>' . $filasVista . '</tbody>
            </table>';
    } else {
        $cuerpoVista = ControladorHTML::getAlertaOperacion($vistas, $controladorVista->getMensaje());
    }
    $filtroVista = "Listado de vistas";
    $cardVista = ControladorHTML::getCardBusqueda($filtroVista, $cuerpoVista);

    $formulario = $cardTabla . "<br>" . $cardProcedimiento . "<br>" . $cardVista;
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $filtro = "Información básica";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
    $card = ControladorHTML::getCardBusqueda($filtro, $cuerpo);
    $boton = ControladorHTML::getBotonBusqueda("formBuscarBase.php");
    $formulario = $card . " " . $boton;
}
?>
<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3">
        <div class="col text-left">
            <h4><i class="fas fa-database"></i> DETALLE DE LA BASE DE DATOS</h4>
        </div>
        <div class="col text-right">
            <a href="bases_buscarBase"><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-times"></i> CERRAR</button></a>
        </div>
    </div>
    <div id="seccionCentral" class="mt-3 mb-4">
        <?= $formulario; ?>
    </div>
</div>