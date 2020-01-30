<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$boton = "";
if ($_POST['idPermiso']) {
    $id = $_POST['idPermiso'];
    $permiso = new Permiso($id);
    $resultado = $permiso->obtener();
    if ($resultado == 2) {
        $nivel = $permiso->getNivel();
        $cuerpo = '<input type="hidden" name="idPermiso" id="idPermiso" value="' . $id . '">
                   <input type="hidden" name="nivel" id="nivel" value="' . $nivel . '">';
        if ($nivel == 1) {
            $cuerpo .= '
                <div class="form-row">
                    <label for="titulo" class="col-sm-2 col-form-label text-left">* Titulo:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2" name="titulo" id="titulo" 
                               minlength="5" maxlength="20" pattern="[A-Za-zÁÉÍÓÚÑáéíóúñ ]{5,20}"
                               value = "' . $permiso->getTitulo() . '"
                               placeholder="Titulo del permiso" required>
                    </div>
                </div>';
        } else {
            $padre = $permiso->getPadre();
            $cuerpo .= '
                <div class="form-row">
                    <label for="titulo" class="col-sm-2 col-form-label text-left">* Titulo:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2" name="titulo" id="titulo" 
                               minlength="5" maxlength="20" pattern="[A-Za-zÁÉÍÓÚÑáéíóúñ ]{5,20}"
                               value = "' . $permiso->getTitulo() . '"
                               placeholder="Titulo del permiso" required>
                    </div>
                    <label for="padre" class="col-sm-2 col-form-label text-left">* Padre:</label>
                    <div class="col">
                        <select class="form-control mb-2" id="padre" name="padre">
                            <option value="' . $padre->getId() . '">' . $padre->getTitulo() . '</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <label for="link" class="col-sm-2 col-form-label text-left">* Link:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2" name="link" id="link" 
                               minlength="5" maxlength="100" pattern="[A-Za-z/.]{5,100}"
                               value = "' . $permiso->getLink() . '"
                               placeholder="Link de acceso">
                    </div>
                </div>';
        }
        $boton = '<button type="submit" class="btn btn-success" 
                              id="btnModificarPermiso" disabled>
                              <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $cuerpo = ControladorHTML::getAlertaOperacion($resultado, $permiso->getMensaje());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}
?>
<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3 mb-3">
        <div class="col text-left">
            <h4><i class="fas fa-user-lock"></i> MODIFICAR PERMISO</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarPermiso" name="formModificarPermiso" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarPermiso.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarPermiso.js"></script>