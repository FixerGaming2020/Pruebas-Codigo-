<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$boton = '';
if (isset($_POST['idBase'])) {
    $idBase = $_POST['idBase'];
    $controladorBase = new ControladorBase();
    $resultado = $controladorBase->obtener($idBase);
    if (gettype($resultado) == "resource") {
        $base = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        $fechaCreacion = isset($base['bfechaCreacion']) ? date_format($base['bfechaCreacion'], 'd/m/Y') : "";
        $cuerpo = '
            <input type="hidden" name="idBase" id="idBase" value="' . $base['bid'] . '">
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
                <label class="col-sm-2 col-form-label">Servidor test:</label>
                <div class="col">
                    <select class="form-control mb-2" name="stest" id="stest">
                        <option value="' . utf8_encode($base['tid']) . '">' . utf8_encode($base['tnombre']) . '</option>
                    </select>
                </div>
                <label class="col-sm-2 col-form-label">Servidor desarrollo:</label>
                <div class="col">
                    <select class="form-control mb-2" name="sdesarrollo" id="sdesarrollo">
                        <option value="' . utf8_encode($base['did']) . '">' . utf8_encode($base['dnombre']) . '</option>
                    </select>
                </div>
            </div>';
        $boton = '<button type="submit" class="btn btn-success" 
                    id="btnModificarBase" disabled>
                    <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $mensaje = $controladorBase->getMensaje();
        $cuerpo = ControladorHTML::getAlertaOperacion($resultado, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}
?>

<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3 mb-3">
        <div class="col text-left">
            <h4><i class="fas fa-database"></i> MODIFICAR BASE DE DATOS</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarBase" name="formModificarBase" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarBase.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarBase.js"></script>