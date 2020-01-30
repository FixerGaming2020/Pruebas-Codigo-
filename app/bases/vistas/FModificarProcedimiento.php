<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

if (isset($_POST['idProcedimiento'])) {
    $idProcedimiento = $_POST['idProcedimiento'];
    $procedimiento = new Procedimiento($idProcedimiento);
    $resultado = $procedimiento->obtener();
    if ($resultado == 2) {

        $creacion = date_format($procedimiento->getFechaCreacion(), 'd/m/Y');
        $edicion = date_format($procedimiento->getFechaEdicion(), 'd/m/Y');
        $proceso = date_format($procedimiento->getFechaProceso(), 'd/m/Y');

        $cuerpo = '
            <input type="hidden" name="idProcedimiento" id="idProcedimiento" value="' . $idProcedimiento . '">
            <div class="form-row">
                <label for="base" class="col-sm-2 col-form-label">Base de datos:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" value="' . utf8_encode($procedimiento->getBase()) . '" disabled>
                </div>
                <label for="nombre" class="col-sm-2 col-form-label">Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" value="' . $procedimiento->getNombre() . '" disabled>
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
                <label for="descripcion" class="col-sm-2 col-form-label">Descripción:</label>
                <div class="col">
                    <textarea class="form-control mb-2"
                              maxlength="500" pattern="[A-Za-zÁÉÍÓÚÑáéíóúñ.,:()=/0-9 ]{0, 500}"
                              title="Descripciión: longitud máxima de 500" rows="5"
                              placeholder="Descripción deL procedimiento almacenado"
                              name="descripcion" id="descripcion">' . $procedimiento->getDescripcion() . '</textarea>
                </div>
            </div>';

        $boton = '<button type="submit" class="btn btn-success" 
                          id="btnModificarProcedimiento" disabled>
                          <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $cuerpo = ControladorHTML::getAlertaOperacion($resultado, $procedimiento->getMensaje());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}
?>
<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3 mb-3">
        <div class="col text-left">
            <h4><i class="fas fa-database"></i> MODIFICAR PROCEDIMIENTO</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarProcedimiento" name="formModificarProcedimiento" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarProcedimiento.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarProcedimiento.js"></script>