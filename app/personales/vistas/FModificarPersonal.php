<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$boton = "";
if ($_POST['idPersonal']) {
    $id = $_POST['idPersonal'];
    $personal = new Personal($id);
    $resultado = $personal->obtener();
    if ($resultado == 2) {
        $departamento = $personal->getDepartamento();
        $rti = $personal->getRti();

        // CARGA LAS OPCIONES DE RIESGO TI
        $opcRti = ($rti == "Si") ? '<option value="Si" selected>Si</option>' : '<option value="Si">Si</option>';
        $opcRti .= ($rti == "No") ? '<option value="No" selected>No</option>' : '<option value="No">No</option>';

        $cuerpo = '
            <input type="hidden" name="idPersonal" id="idPersonal" value="' . $personal->getId() . '">
            <div class="form-row">
                <label for="sigla" class="col-sm-2 col-form-label">* Nombre corto:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="sigla" id="sigla" maxlength="20"
                           value="' . $personal->getSigla() . '"
                           placeholder="Nombre corto" required>
                </div>
                <label for="nombre" class="col-sm-2 col-form-label">* Nombre largo:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" maxlength="50"
                           value="' . $personal->getNombre() . '"
                           placeholder="Nombre largo" required>
                </div>
            </div>
            <div class="form-row">
                <label for="departamento" class="col-sm-2 col-form-label">* Departamento:</label>
                <div class="col">
                    <select class="form-control mb-2" id="departamento" name="departamento">
                        <option value="' . $departamento->getId() . '">' . $departamento->getNombre() . '</option>
                    </select>
                </div>
                <label for="rti" class="col-sm-2 col-form-label">* RTI:</label>
                <div class="col">
                    <select class="form-control mb-2" id="rti" name="rti">' . $opcRti . '</select>
                </div>
            </div>';
        $boton = '<button type="submit" class="btn btn-success"
                    id="btnModificarPersonal" disabled>
                    <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $mensaje = $personal->getId();
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
            <h4><i class="fas fa-fire-alt"></i> MODIFICAR PERSONAL</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarPersonal" name="formModificarPersonal" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarPersonal.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarPersonal.js"></script>
