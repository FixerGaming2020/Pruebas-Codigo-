<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

if (isset($_POST['idTabla'])) {
    $id = $_POST['idTabla'];
    $tabla = new Tabla($id);
    $resultado = $tabla->obtener();
    if ($resultado == 2) {
        $creacion = date_format($tabla->getFechaCreacion(), 'd/m/Y');
        $edicion = date_format($tabla->getFechaEdicion(), 'd/m/Y');
        $proceso = date_format($tabla->getFechaProceso(), 'd/m/Y');
        $cuerpo = '
            <input type="hidden" name="idTabla" id="idTabla" value="' . $tabla->getId() . '">
            <div class="form-row">
                <label for="sigla" class="col-sm-2 col-form-label">Base de datos:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" value="' . utf8_encode($tabla->getBase()) . '" disabled>
                </div>
                <label for="nombre" class="col-sm-2 col-form-label">Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" value="' . $tabla->getNombre() . '" disabled>
                </div>
            </div>
            <div class="form-row">
                <label for="sigla" class="col-sm-2 col-form-label">Fecha creación:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" value="' . $creacion . '" disabled>
                </div>
                <label for="nombre" class="col-sm-2 col-form-label">Fecha edición:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" value="' . $edicion . '" disabled>
                </div>
            </div>
            <div class="form-row">
                <label for="sigla" class="col-sm-2 col-form-label">Fecha proceso:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" value="' . $proceso . '" disabled>
                </div>
                <label class="col-sm-2 col-form-label"></label>
                <div class="col">
                </div>
            </div>
            <div class="form-row">
                <label for="sigla" class="col-sm-2 col-form-label">Total de campos:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           value="' . $tabla->getCampos() . '" disabled>
                </div>
                <label class="col-sm-2 col-form-label"></label>
                <div class="col">
                    <a href="PDescargarPDFCampo.php?ref=' . $tabla->getId() . '&name=' . $tabla->getNombre() . '">
                        <button type="button" class="btn btn-outline-success">
                            <i class="far fa-file-pdf"></i> DESCARGAR</button>
                    </a>
                </div>
            </div>
            <div class="form-row">
                <label for="descripcion" class="col-sm-2 col-form-label">Descripción:</label>
                <div class="col">
                    <textarea class="form-control mb-2"
                              placeholder="Descripción de la vista"
                              disabled>' . $tabla->getDescripcion() . '</textarea>
                </div>
            </div>';
    } else {
        $mensaje = $tabla->getMensaje();
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
            <h4><i class="fas fa-database"></i> DETALLE TABLA</h4>
        </div>
    </div>
    <div class="card border-azul-clasico mt-3">
        <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
        <div class="card-body">
            <?= $cuerpo; ?>
        </div>
    </div>
    <div class="form-row mt-2 mb-4">
        <div class="col text-right">
            <a href="FBuscarTabla.php">
                <button type="button" class="btn btn-outline-info">
                    <i class="fas fa-search"></i> BUSCAR
                </button>
            </a>
        </div>
    </div>
</div>