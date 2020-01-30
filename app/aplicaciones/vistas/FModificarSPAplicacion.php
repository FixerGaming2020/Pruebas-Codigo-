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

        $sProduccion = $aplicacion->getSProduccion();
        $sTest = $aplicacion->getSTest();
        $sDesarrollo = $aplicacion->getSDesarrollo();

        //CARGA LAS OPCIONES DINAMICAS
        $opcSProduccion = ($sProduccion) ? '<option value="' . $sProduccion->getIp() . '">' . $sProduccion->getNombre() . '</option>' : '';
        $opcSTest = ($sTest) ? '<option value="' . $sTest->getId() . '">' . $sTest->getNombre() . '</option>' : '';
        $opcSDesarrollo = ($sDesarrollo) ? '<option value="' . $sDesarrollo->getId() . '">' . $sDesarrollo->getNombre() . '</option>' : '';

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
                <label for="sproduccion" class="col-sm-2 col-form-label">Servidor producción:</label>
                <div class="col">
                    <select class="form-control mb-2" id="sproduccion" name="sproduccion">' . $opcSProduccion . '</select>
                </div>
                <label for="pdesarrollo" class="col-sm-2 col-form-label">Puerto producción:</label>
                <div class="col">
                    <input type="number" class="form-control mb-2" 
                           name="pproduccion" id="pproduccion" min="1"
                           value="' . $aplicacion->getPProduccion() . '"
                           placeholder="Puerto de produccion">
                </div>
            </div>
            <div class="form-row">
                <label for="stest" class="col-sm-2 col-form-label">Servidor test:</label>
                <div class="col">
                    <select class="form-control mb-2" id="stest" name="stest">' . $opcSTest . '</select>
                </div>
                <label for="ptest" class="col-sm-2 col-form-label">Puerto desarrollo:</label>
                <div class="col">
                    <input type="number" class="form-control mb-2" 
                           name="ptest" id="ptest" min="1"
                           value="' . $aplicacion->getPTest() . '"
                           placeholder="Puerto de test">
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
    <form id="formModificarSPAplicacion" name="formModificarSPAplicacion" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarSPAplicacion.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarSPAplicacion.js"></script>
