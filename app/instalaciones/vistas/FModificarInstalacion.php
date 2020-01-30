<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$boton = "";
if ($_POST['idInstalacion']) {
    $id = $_POST['idInstalacion'];
    $instalacion = new Instalacion($id);
    $resultado = $instalacion->obtener();
    if ($resultado == 2) {
        $gerencia = $instalacion->getGerencia();
        $responsable = $instalacion->getEmpleado();
        $ubicacion = $instalacion->getSitio();
        $plataforma = $instalacion->getPlataforma();
        $rti = $instalacion->getRti();

        $opcionesRTI = ($rti == "Si") ? '<option value="Si" selected>Si</option>' : '<option value="Si">Si</option>';
        $opcionesRTI .= ($rti == "No") ? '<option value="No" selected>No</option>' : '<option value="No">No</option>';

        $cuerpo = '
            <input type="hidden" name="idInstalacion" id="idInstalacion" value="' . $instalacion->getId() . '">
            <div class="form-row">
                <label for="sigla" class="col-sm-2 col-form-label">* Nombre corto:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="sigla" id="sigla" maxlength="20" 
                           value="' . $instalacion->getSigla() . '"
                           placeholder="Nombre corto" required>
                </div>
                <label for="nombre" class="col-sm-2 col-form-label">* Nombre largo:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" maxlength="50"
                           value="' . $instalacion->getNombre() . '"
                           placeholder="Nombre largo" required>
                </div>
            </div>
            <div class="form-row">
                <label for="gerencia" class="col-sm-2 col-form-label">* Gerencia:</label>
                <div class="col">
                    <select class="form-control mb-2" name="gerencia" id="gerencia" required>
                        <option value="' . $gerencia->getId() . '">' . $gerencia->getNombre() . '</option>
                    </select>
                </div>
                <label for="responsable" class="col-sm-2 col-form-label">* Responsable:</label>
                <div class="col">
                    <select class="form-control mb-2" name="responsable" id="responsable" required>
                        <option value="' . $responsable->getId() . '">' . $responsable->getNombre() . '</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <label for="ubicacion" class="col-sm-2 col-form-label">* Ubicación:</label>
                <div class="col">
                    <select class="form-control mb-2" name="ubicacion" id="ubicacion" required>
                        <option value="' . $ubicacion->getId() . '">' . $ubicacion->getNombre() . '</option>
                    </select>
                </div>
                <label for="plataforma" class="col-sm-2 col-form-label">* Plataforma:</label>
                <div class="col">
                    <select class="form-control mb-2" name="plataforma" id="plataforma">
                        <option value="' . $plataforma->getId() . '">' . $plataforma->getNombre() . '</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <label for="ubicacion" class="col-sm-2 col-form-label">* RTI:</label>
                <div class="col">
                    <select class="form-control mb-2" name="rti" id="rti">' . $opcionesRTI . '</select>
                </div>
                <label class="col-sm-2 col-form-label"></label>
                <div class="col"></div>
            </div>
            <div class="form-row">
                <label for="descripcion" class="col-sm-2 col-form-label">* Descripción:</label>
                <div class="col">
                    <textarea class="form-control mb-2" 
                              name="descripcion" id="descripcion" maxlength="150"
                              placeholder="Descripción de la instalación" required>' . $instalacion->getDescripcion() . '</textarea>
                </div>
            </div>';
        $boton = '<button type="submit" class="btn btn-success" id="btnModificarInstalacion" disabled>
                              <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $cuerpo = ControladorHTML::getAlertaOperacion(0, $instalacion->getMensaje());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}
?>

<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3 mb-3">
        <div class="col text-left">
            <h4><i class="fas fa-code-branch"></i> MODIFICAR INSTALACIÓN</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarInstalacion" name="formModificarInstalacion" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarInstalacion.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarInstalacion.js"></script>
