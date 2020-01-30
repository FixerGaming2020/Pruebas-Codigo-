<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$boton = "";
if ($_POST['idAplicacion']) {
    $id = $_POST['idAplicacion'];
    $aplicacion = new Aplicacion($id);
    $resultado = $aplicacion->obtener();
    if ($resultado == 2) {
        $cuerpo = '
            <input type="hidden" name="idAplicacion" id="idAplicacion" value="' . $aplicacion->getId() . '"/>
            <div class="form-row">
                <label for="sigla" class="col-sm-2 col-form-label">* Nombre corto:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="sigla" id="sigla" minlength="3" maxlength="50"
                           value="' . $aplicacion->getSigla() . '"
                           placeholder="Nombre corto" readonly>
                </div>
                <label for="nombre" class="col-sm-2 col-form-label">* Nombre largo:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" minlength="3" maxlength="50"
                           value="' . $aplicacion->getNombre() . '"
                           placeholder="Nombre largo" readonly>
                </div>
            </div>
            <div class="form-row">
                <label for="confidencialidad" class="col-sm-2 col-form-label">* Confidencialidad:</label>
                <div class="col">
                    <input type="number" class="form-control mb-2" 
                           name="confidencialidad" id="confidencialidad" 
                           min="1" max="10" placeholder="Valor de confidencialidad"
                           value="' . $aplicacion->getConfidencialidad() . '" required>
                </div>
                <label for="integridad" class="col-sm-2 col-form-label">* Integridad:</label>
                <div class="col">
                    <input type="number" class="form-control mb-2" 
                           name="integridad" id="integridad" 
                           min="1" max="10" required placeholder="Valor de integridad"
                           value="' . $aplicacion->getIntegridad() . '">
                </div>
            </div>
            <div class="form-row">
                <label for="disponibilidad" class="col-sm-2 col-form-label">* Disponibilidad:</label>
                <div class="col">
                    <input type="number" class="form-control mb-2" 
                           name="disponibilidad" id="disponibilidad" 
                           min="1" max="10" required placeholder="Valor de disponibilidad"
                           value="' . $aplicacion->getDisponibilidad() . '"/>
                </div>
                <label for="criticidad" class="col-sm-2 col-form-label">* Criticidad:</label>
                <div class="col">
                    <input type="number" class="form-control mb-2" 
                           name="criticidad" id="criticidad" min="1" max="10"
                           placeholder="Valor de criticidad"
                           value="' . $aplicacion->getCriticidad() . '" required>
                </div>
            </div>';
        $boton = '<button type="submit" class="btn btn-success" 
                    id="btnModificarAplicacion" disabled>
                    <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $mensaje = $aplicacion->getMensaje();
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
            <h4><i class="fas fa-desktop"></i> MODIFICAR APLICACIÓN</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarTPAplicacion" name="formModificarTPAplicacion" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarTPAplicacion.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarTPAplicacion.js"></script>


