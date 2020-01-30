<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$cuerpo = $boton = "";
if (isset($_POST['idServicio'])) {
    $id = $_POST['idServicio'];
    $servicio = new Servicio($id);
    $resultado = $servicio->obtener();
    if ($resultado == 2) {
        $cuerpo = '
            <input type="hidden" name="idServicio" id="idServicio" value="' . $servicio->getId() . '">
            <div class="form-row">
                <label for="sigla" class="col-sm-2 col-form-label">* Nombre corto:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="sigla" id="sigla" maxlength="20"
                           value="' . $servicio->getSigla() . '"
                           placeholder="Nombre corto para el servicio">
                </div>
                <label for="nombre" class="col-sm-2 col-form-label">* Nombre largo:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" maxlength="50"
                           value="' . $servicio->getNombre() . '"
                           placeholder="Nombre del servicio">
                </div>
            </div>
            <div class="form-row">
                <label for="nombre" class="col-sm-2 col-form-label">* Descripción:</label>
                <div class="col">
                    <textarea class="form-control" name="descripcion" id="descripcion" maxlength="500">' . $servicio->getDescripcion() . '</textarea>
                </div>
            </div>';
        $boton = '
            <button type="submit" class="btn btn-success" 
                    id="btnModificarServicio" disabled>
                    <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $cuerpo = ControladorHTML::getAlertaOperacion($resultado, $servicio->getMensaje());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}
?>
<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3 mb-3">
        <div class="col text-left">
            <h4><i class="fab fa-connectdevelop"></i> MODIFICAR SERVICIO</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <div id="seccionCentral">
        <form id="formModificarServicio" name="formModificarServicio" method="POST">
            <div class="card border-azul-clasico">
                <div class="card-header text-left bg-azul-clasico text-white">Formulario de modificación</div>
                <div class="card-body">
                    <?= $cuerpo; ?>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <?= $boton; ?>
                    <a href="FBuscarServicio.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/ModificarServicio.js"></script>