<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$boton = "";
if ($_POST['idEmpleado']) {
    $id = $_POST['idEmpleado'];
    $empleado = new Empleado($id);
    $resultado = $empleado->obtener();
    if ($resultado == 2) {
        $departamento = $empleado->getDepartamento();
        $option = isset($departamento) ? '<option value="' . $departamento->getId() . '">' . $deparamento->getNombre() . '</option>' : "";
        $cuerpo = '
            <input type="hidden" name="idEmpleado" id="idEmpleado" value="' . $empleado->getId() . '">
            <div class="form-row">
                <label for="legajo" class="col-sm-2 col-form-label text-left">* Legajo:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="legajo" id="legajo" maxlength="10"
                           value="' . $empleado->getId() . '"
                           placeholder="Número de legajo" required>
                </div>
                <label for="nombre" class="col-sm-2 col-form-label text-left">* Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" 
                           value="' . $empleado->getNombre() . '"
                           placeholder="Nombre completo" required>
                </div>
            </div>
            <div class="form-row">
                <label for="departamento" class="col-sm-2 col-form-label text-left">Departamento:</label>
                <div class="col">
                    <select id="departamento" name="departamento" class="form-control mb-2">' . $option . '</select>
                </div>
                <label class="col-sm-2 col-form-label text-left"></label>
                <div class="col"></div>
            </div>';
        $boton = '
            <button type="submit" class="btn btn-success" 
                    id="btnModificarEmpleado" disabled>
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
            <h4><i class="fas fa-building"></i> MODIFICAR EMPLEADO</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarEmpleado" name="formModificarEmpleado" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarEmpleado.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarEmpleado.js"></script>