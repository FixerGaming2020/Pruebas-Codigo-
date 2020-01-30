<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$boton = '';
if (isset($_POST['idColumna'])) {
    $idColumna = $_POST['idColumna'];
    $columna = new Columna($idColumna);
    $resultado = $columna->obtener();
    if ($resultado == 2) {
        $cuerpo = '
        <input type="hidden" name="idColumna" id="idColumna" value="' . $columna->getId() . '">
        <div class="form-row">
            <label class="col-sm-2 col-form-label">Tabla:</label>
            <div class="col">
                <input type="text" class="form-control mb-2" 
                       value="' . $columna->getTabla() . '" disabled>
            </div>
            <label class="col-sm-2 col-form-label">Nombre:</label>
            <div class="col">
                <input type="text" class="form-control mb-2"
                       value="' . $columna->getNombre() . '" disabled>
            </div>
        </div>
        <div class="form-row">
            <label class="col-sm-2 col-form-label">Nulos:</label>
            <div class="col">
                <input type="text" class="form-control mb-2" 
                       value="' . $columna->getNulos() . '" disabled>
            </div>
            <label class="col-sm-2 col-form-label">Tipo dato:</label>
            <div class="col">
                <input type="text" class="form-control mb-2"
                       value="' . $columna->getTipo() . '" disabled>
            </div>
        </div>
        <div class="form-row">
            <label class="col-sm-2 col-form-label">Tamaño máximo:</label>
            <div class="col">
                <input type="text" class="form-control mb-2" 
                       value="' . $columna->getMaximo() . '" disabled>
            </div>
            <label class="col-sm-2 col-form-label"></label>
            <div class="col"></div>
        </div>
        <div class="form-row">
            <label class="col-sm-2 col-form-label">Descripción:</label>
            <div class="col">
                <textarea class="form-control mb-2" 
                          name="descripcion" id="descripcion" rows="4" 
                          placeholder="Descripción de la columna">' . $columna->getDescripcion() . '</textarea>
            </div>
        </div>';
        $boton = '<button type="submit" class="btn btn-success" 
                    id="btnModificarColumna" disabled>
                    <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $mensaje = $columna->getMensaje();
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
            <h4><i class="fas fa-database"></i> MODIFICAR COLUMNA</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarColumna" name="formModificarColumna" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarCampo.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarCampo.js"></script>

