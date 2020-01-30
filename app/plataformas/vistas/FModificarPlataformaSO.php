<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$boton = "";
if ($_POST['idPlataforma']) {
    $id = $_POST['idPlataforma'];
    $plataforma = new PlataformaSO($id);
    $resultado = $plataforma->obtener();
    if ($resultado == 2) {
        $cuerpo = '
            <input type="hidden" name="idPlataforma" id="idPlataforma" value="' . $plataforma->getId() . '">
            <div class="form-row">
                <label for="nombre" class="col-sm-2 col-form-label">* Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" maxlength="50"
                           value="' . $plataforma->getNombre() . '"
                           placeholder="Nombre" required>
                </div>
            </div>';
        $boton = '<button type="submit" class="btn btn-success" 
                          id="btnModificarPlataforma" disabled>
                          <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $cuerpo = ControladorHTML::getAlertaOperacion($resultado, $plataforma->getMensaje());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}
?>
<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3 mb-3">
        <div class="col text-left">
            <h4><i class="fas fa-hdd"></i> MODIFICAR PLATAFORMA SO</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarPlataforma" name="formModificarPlataforma" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarPlataformaSO.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarPlataformaSO.js"></script>