<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();

$boton = "";
if (isset($_POST['idResponsable'])) {
    $id = $_POST['idResponsable'];
    $responsable = new Responsable($id);
    $resultado = $responsable->obtener();
    if ($resultado == 2) {
        $proveedor = $responsable->getProveedor();
        $cuerpo = '
            <input type="hidden" name="idResponsable" id="idResponsable" value="' . $responsable->getId() . '">
            <div class="form-row">
                <label for="proveedor" class="col-sm-2 col-form-label">* Proveedor:</label>
                <div class="col">
                    <select class="form-control mb-2" id="proveedor" name="proveedor">
                        <option value="' . $proveedor->getId() . '">' . $proveedor->getNombre() . '</option>
                    </select>
                </div>
                <label for="nombre" class="col-sm-2 col-form-label">* Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" maxlength="50"
                           value="' . $responsable->getNombre() . '"
                           placeholder="Nombre del responsable" required>
                </div>
            </div>
            <div class="form-row">
                <label for="telefono" class="col-sm-2 col-form-label">Telefono:</label>
                <div class="col">
                    <input type="tel" class="form-control mb-2" 
                           name="telefono" id="telefono" maxlength="20"
                           value="' . $responsable->getTelefono() . '"
                           placeholder="Número de telefono">
                </div>
                <label for="correo" class="col-sm-2 col-form-label">* Correo:</label>
                <div class="col">
                    <input type="email" class="form-control mb-2" 
                           name="correo" id="correo" maxlength="50"
                           value="' . $responsable->getCorreo() . '"
                           placeholder="Correo electrónico" required>
                </div>
            </div>';
        $boton = '
            <button type="submit" class="btn btn-success" id="btnModificarResponsable" disabled>
                    <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $mensaje = $responsable->getMensaje();
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
            <h4><i class="far fa-address-card"></i> MODIFICAR RESPONSABLE</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <div id="seccionCentral">
        <form id="formModificarResponsable" name="formModificarResponsable" method="POST">
            <div class="card mt-3 ">
                <div class="card-header text-left bg-azul-clasico text-white">Formulario de modificación</div>
                <div class="card-body">
                    <?= $cuerpo; ?>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <?= $boton; ?>
                    <a href="FBuscarResponsable.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/ModificarResponsable.js"></script>