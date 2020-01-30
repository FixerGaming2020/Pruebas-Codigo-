<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

if (isset($_POST['idBase'])) {
    $idBase = $_POST['idBase'];
    $controladorBase = new ControladorBase();
    $resultado = $controladorBase->obtener($idBase);
    if (gettype($resultado) == "resource") {
        $base = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        $fechaCreacion = isset($base['bfechaCreacion']) ? date_format($base['bfechaCreacion'], 'd/m/Y') : "";
        $fechaProceso = isset($base['bfechaProceso']) ? date_format($base['bfechaProceso'], 'd/m/Y') : "";
        $cuerpoBase = '
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           value="' . utf8_encode($base['bnombre']) . '" disabled>
                </div>
                <label class="col-sm-2 col-form-label">Fecha de creación:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2"
                           value="' . $fechaCreacion . '" disabled>
                </div>
            </div>
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Motor:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                            value="' . utf8_encode($base['bmotor']) . '" disabled>
                </div>
                <label for="sigla" class="col-sm-2 col-form-label">Collation:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                            value="' . utf8_encode($base['bcollation']) . '" disabled>
                </div>
            </div>
            <div class="form-row">
                <label class="col-sm-2 col-form-label">IP producción:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           value="' . utf8_encode($base['pid']) . '" 
                           placeholder="IP del servidor en producción" disabled>
                </div>
                <label class="col-sm-2 col-form-label">Nombre producción:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           value="' . utf8_encode($base['pnombre']) . '" 
                           placeholder="Nombre del servidor en producción" disabled>
                </div>
            </div>
            <div class="form-row">
                <label class="col-sm-2 col-form-label">IP test:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           value="' . utf8_encode($base['tid']) . '" 
                           placeholder="IP del servidor en test" disabled>
                </div>
                <label class="col-sm-2 col-form-label">Test:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           value="' . utf8_encode($base['tnombre']) . '"
                           placeholder="Nombre del servidor en test" disabled>
                </div>
            </div>
            <div class="form-row">
                <label class="col-sm-2 col-form-label">IP desarrollo:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           value="' . utf8_encode($base['did']) . '" 
                           placeholder="IP del servidor en desarrollo" disabled>
                </div>
                <label class="col-sm-2 col-form-label">Nombre desarrollo:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           value="' . utf8_encode($base['dnombre']) . '"
                           placeholder="Nombre del servidor en desarrollo" disabled>
                </div>
            </div>
            <div class="form-row">
                <label for="nombre" class="col-sm-2 col-form-label">Estado:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           value="' . utf8_encode($base['bestado']) . '" disabled>
                </div>
                <label class="col-sm-2 col-form-label">Fecha de proceso:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2"
                           value="' . $fechaCreacion . '" disabled>
                </div>
            </div>
            <div class="form-row">
                <label for="sigla" class="col-sm-2 col-form-label">Total de tablas:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           value="' . utf8_encode($base['btablas']) . '" disabled>
                </div>
                <label class="col-sm-2 col-form-label"></label>
                <div class="col">
                    <a href="PDescargarPDFTabla.php?ref=' . $base['bid'] . '&name=' . utf8_encode($base['bnombre']) . '" >
                        <button type="button" class="btn btn-outline-success">
                            <i class="far fa-file-pdf"></i> DESCARGAR</button>
                    </a>
                </div>
            </div>
            <div class="form-row">
                <label for="sigla" class="col-sm-2 col-form-label">Total de vistas:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2"
                           value="' . utf8_encode($base['bvistas']) . '" disabled>
                </div>
                <label class="col-sm-2 col-form-label"></label>
                <div class="col">
                    <a href="PDescargarPDFVista.php?ref=' . $base['bid'] . '&name=' . utf8_encode($base['bnombre']) . '">
                        <button type="button" class="btn btn-outline-success">
                            <i class="far fa-file-pdf"></i> DESCARGAR</button>
                    </a>
                </div>
            </div>
            <div class="form-row">
                <label for="sigla" class="col-sm-2 col-form-label">Total de SPs:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           value="' . utf8_encode($base['bprocedimientos']) . '" disabled>
                </div>
                <label class="col-sm-2 col-form-label"></label>
                <div class="col">
                    <a href="PDescargarPDFSP.php?ref=' . $base['bid'] . '&name=' . utf8_encode($base['bnombre']) . '">
                        <button type="button" class="btn btn-outline-success">
                            <i class="far fa-file-pdf"></i> DESCARGAR</button>
                    </a>
                </div>
            </div>';
        $formulario = ControladorHTML::getCardBusqueda("Información básica", $cuerpoBase);
    } else {
        $mensaje = $controladorBase->getMensaje();
        $filtro = "Información básica";
        $cuerpo = ControladorHTML::getAlertaOperacion($resultado, $mensaje);
        $formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $filtro = "Información básica";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
    $formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);
}
?>
<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3">
        <div class="col text-left">
            <h4><i class="fas fa-database"></i> DETALLE DE LA BASE DE DATOS</h4>
        </div>
    </div>
    <div id="seccionCentral" class="mt-3 mb-4">
        <?= $formulario; ?>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <a href="FBuscarBase.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>