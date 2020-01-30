<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$boton = "";
if ($_POST['idActivoHijo']) {
    $hijo = new ActivoHijo($_POST['idActivoHijo']);
    $resultado = $hijo->obtener();
    if ($resultado == 2) {
        $cuerpo = '
            <input type="hidden" name="idActivoHijo" id="idActivoHijo" value="' . $hijo->getId() . '"/>
            <div class="form-row">
                <label for="sigla" class="col-sm-2 col-form-label">* Nombre corto:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="sigla" id="sigla" minlength="3" maxlength="10"
                           value="' . $hijo->getSigla() . '"
                           placeholder="Nombre corto del activo" required>
                </div>
                <label for="nombre" class="col-sm-2 col-form-label">* Nombre largo:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" minlength="5" maxlength="50"
                           value="' . $hijo->getNombre() . '"
                           placeholder="Nombre del activo" required>
                </div>
            </div>';
        $boton = '<button type="submit" class="btn btn-success" 
                    id="btnModificarActivoHijo" disabled>
                    <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $mensaje = $hijo->getMensaje();
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
            <h4><i class="fas fa-list"></i> MODIFICAR ACTIVO HIJO</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarActivoHijo" name="formModificarActivoHijo" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarActivoHijo.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarActivoHijo.js"></script>

