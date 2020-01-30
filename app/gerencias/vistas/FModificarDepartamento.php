<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$boton = "";
if ($_POST['idDepartamento']) {
    $deparamento = new Departamento($_POST['idDepartamento']);
    $resultado = $deparamento->obtener();
    if ($resultado == 2) {
        $gerencia = $deparamento->getGerencia();
        $cuerpo = '
            <input type="hidden" name="idDepartamento" id="idDepartamento" value="' . $deparamento->getId() . '">
            <div class="form-row">
                <label for="nombre" class="col-sm-2 col-form-label text-left">* Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" 
                           value="' . $deparamento->getNombre() . '"
                           placeholder="Nombre del departamento">
                </div>
                <label for="gerencia" class="col-sm-2 col-form-label text-left">* Gerencia:</label>
                <div class="col">
                    <select class="form-control mb-2" id="gerencia" name="gerencia">
                        <option value="' . $gerencia->getId() . '">' . $gerencia->getNombre() . '</option>
                    </select>
                </div>
            </div>';
        $boton = '
            <button type="submit" class="btn btn-success" 
                    id="btnModificarDepartamento" disabled>
                    <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $cuerpo = ControladorHTML::getAlertaOperacion($resultado, $deparamento->getMensaje());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}
?>
<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3 mb-3">
        <div class="col text-left">
            <h4><i class="fas fa-building"></i> MODIFICAR DEPARTAMENTO</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarDepartamento" name="formModificarDepartamento" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarDepartamento.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarDepartamento.js"></script>

