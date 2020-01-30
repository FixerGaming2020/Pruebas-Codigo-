<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$boton = "";
if ($_POST['idHerramienta']) {
    $id = $_POST['idHerramienta'];
    $herramienta = new HerramientaDesarrollo($id);
    $resultado = $herramienta->obtener();
    if ($resultado == 2) {
        $cuerpo = '
            <input type="hidden" name="idHerramienta" id="idHerramienta" value="' . $herramienta->getId() . '">
            <div class="form-row">
                <label for="nombre" class="col-sm-2 col-form-label">* Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" maxlength="50"
                           value = "' . $herramienta->getNombre() . '"
                           placeholder="Nombre" required>
                </div>
                <label for="version" class="col-sm-2 col-form-label">* Versión:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="version" id="version" maxlength="20"
                           value = "' . $herramienta->getVersion() . '"
                           placeholder="Versión" required>
                </div>
            </div>
            <div class="form-row">
                <label for="fabricante" class="col-sm-2 col-form-label">* Fabricante:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="fabricante" id="fabricante" maxlength="50"
                           value = "' . $herramienta->getFabricante() . '"
                           placeholder="Nombre del fabricante" required>
                </div>
                <label class="col-sm-2 col-form-label"></label>
                <div class="col"></div>
            </div>
            <div class="form-row">
                <label for="descripcion" class="col-sm-2 col-form-label">* Descripción:</label>
                <div class="col">
                    <textarea class="form-control mb-2" 
                              name="descripcion" id="descripcion" maxlength="100"
                              placeholder="Descripción adicional" required>' . $herramienta->getDescripcion() . '</textarea>
                </div>
            </div>';
        $boton = '<button type="submit" class="btn btn-success" 
                          id="btnModificarHerramienta" disabled>
                          <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $cuerpo = ControladorHTML::getAlertaOperacion($resultado, $herramienta->getMensaje());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}
?>
<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3 mb-3">
        <div class="col text-left">
            <h4><i class="fas fa-laptop-code"></i> MODIFICAR HERRAMIENTA</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarHerramienta" name="formModificarHerramienta" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarHerramienta.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarHerramienta.js"></script>