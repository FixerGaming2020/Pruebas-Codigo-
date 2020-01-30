<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$cuerpo = $boton = "";
if (isset($_POST['idSitio'])) {
    $sitio = new Sitio($_POST['idSitio']);
    $resultado = $sitio->obtener();
    if ($resultado == 2) {

        $tipo = ($sitio->getTipo() == "CPD") ? '<option value="CPD" selected>Centro de procesamiento de datos</option>' : '<option value="CPD">Centro de procesamiento de datos</option>';
        $tipo .= ($sitio->getTipo() == "SAR") ? '<option value="SAR" selected>Sitio de almacenamiento de resguardos</option>' : '<option value="SAR">Sitio de almacenamiento de resguardos</option>';
        $tipo .= ($sitio->getTipo() == "SUC") ? '<option value="SUC" selected>Sucursal</option>' : '<option value="SUC">Sucursal</option>';

        if ($sitio->getOrigen() == "Propio") {
            $origen = '<option value="Propio" selected>Propio</option>
                       <option value="Tercerizado">Tercerizado</option>';
        } else {
            $origen = '<option value="Propio">Propio</option>
                       <option value="Tercerizado" selected>Tercerizado</option>';
        }
        $cuerpo = '
            <div class="form-row">
                <label for="codigo" class="col-sm-2 col-form-label">* Código:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="codigo" id="codigo" maxlength="5"
                           value="' . $sitio->getId() . '"
                           placeholder="Código del sitio">
                </div>
                <label for="tipo" class="col-sm-2 col-form-label">* Tipo:</label>
                <div class="col">
                    <select class="form-control mb-2" name="tipo" id="tipo">' . $tipo . '</select>
                </div>
            </div>
            <div class="form-row">
                <label for="nombre" class="col-sm-2 col-form-label">* Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" maxlength="50"
                           value="' . $sitio->getNombre() . '"
                           placeholder="Nombre del sitio">
                </div>
                <label for="provincia" class="col-sm-2 col-form-label">* Provincia</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="provincia" id="provincia" maxlength="50"
                           value="' . $sitio->getProvincia() . '"
                           placeholder="Nombre de la provincia">
                </div>
            </div>
            <div class="form-row">
                <label for="localidad" class="col-sm-2 col-form-label">* Localidad:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="localidad" id="localidad" maxlength="50"
                           value="' . $sitio->getCiudad() . '"
                           placeholder="Nombre de la localidad">
                </div>
                <label class="col-sm-2 col-form-label">* Código postal:</label>
                <div class="col">
                    <input type="number" class="form-control mb-2" 
                           name="codigoPostal" id="codigoPostal" maxlength="50"
                           value="' . $sitio->getCodigoPostal() . '"
                           placeholder="Código postal">
                </div>
            </div>
            <div class="form-row">
                <label for="direccion" class="col-sm-2 col-form-label">* Dirección:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="direccion" id="direccion" maxlength="50"
                           value="' . $sitio->getDireccion() . '"
                           placeholder="Dirección">
                </div>
                <label class="col-sm-2 col-form-label">* Origen:</label>
                <div class="col">
                    <select class="form-control mb-2" name="origen" id="origen">' . $origen . '</select>
                </div>
            </div>';
        $boton = '
            <button type="submit" class="btn btn-success" id="btnModificarSitio" disabled>
                    <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $cuerpo = ControladorHTML::getAlertaOperacion($resultado, $sitio->getMensaje());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}
?>
<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3 mb-3">
        <div class="col text-left">
            <h4><i class="far fa-building"></i> MODIFICAR SITIO</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <div id="seccionCentral">
        <form id="formModificarSitio" name="formModificarSitio" method="POST">
            <div class="card border-azul-clasico">
                <div class="card-header text-left bg-azul-clasico text-white">Formulario de modificación</div>
                <div class="card-body">
                    <?= $cuerpo; ?>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <?= $boton; ?>
                    <a href="FBuscarSitio.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/ModificarSitio.js"></script>