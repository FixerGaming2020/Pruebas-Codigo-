<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$boton = "";
if ($_POST['idSwitch']) {
    $id = $_POST['idSwitch'];
    $switch = new Switchs($id);
    $resultado = $switch->obtener();
    if ($resultado == 2) {
        $instalacion = $switch->getInstalacion();
        $sitio = $switch->getSitio();
        $rti = $switch->getRti();

        $opcionesRTI = ($rti == "Si") ? '<option value="Si" selected>Si</option>' : '<option value="Si">Si</option>';
        $opcionesRTI .= ($rti == "No") ? '<option value="No" selected>No</option>' : '<option value="No">No</option>';

        $cuerpo = '
            <input type="hidden" name="idSwitch" id="idSwitch" value="' . $switch->getId() . '">
            <div class="form-row">
                <label for="nombre" class="col-sm-2 col-form-label">* Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" maxlength="50"
                           value="' . $switch->getNombre() . '"
                           placeholder="Nombre" required>
                </div>
                <label for="modelo" class="col-sm-2 col-form-label">* Modelo:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="modelo" id="modelo" maxlength="20"
                           value="' . $switch->getModelo() . '"
                           placeholder="Modelo" required>
                </div>
            </div>
            <div class="form-row">
                <label for="version" class="col-sm-2 col-form-label">* Versión:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="version" id="version" maxlength="50"
                           value="' . $switch->getVersion() . '"
                           placeholder="IOS Versión" required>
                </div>
                <label for="instalacion" class="col-sm-2 col-form-label">* Instalación:</label>
                <div class="col">
                    <select class="form-control mb-2" name="instalacion" id="instalacion">
                        <option value="' . $instalacion->getId() . '">' . $instalacion->getNombre() . '</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <label for="sitio" class="col-sm-2 col-form-label">* Ubicación:</label>
                <div class="col">
                    <select class="form-control mb-2" name="sitio" id="sitio">
                        <option value="' . $sitio->getId() . '">' . $sitio->getNombre() . '</option>
                    </select>
                </div>
                <label for="rti" class="col-sm-2 col-form-label">* RTI:</label>
                <div class="col">
                    <select class="form-control mb-2" name="rti" id="rti">' . $opcionesRTI . '</select>
                </div>
            </div>';
        $boton = '
            <button type="submit" class="btn btn-success" id="btnModificarSwitch" disabled>
                    <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $cuerpo = ControladorHTML::getAlertaOperacion($resultado, $switch->getMensaje());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}
?>
<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3 mb-3">
        <div class="col text-left">
            <h4><i class="fas fa-ethernet"></i> MODIFICAR SWITCH</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarSwitch" name="formModificarSwitch" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarSwitch.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarSwitch.js"></script>