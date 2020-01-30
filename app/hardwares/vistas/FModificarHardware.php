<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$boton = "";
if (isset($_POST['idHardware'])) {
    $id = $_POST['idHardware'];
    $hardware = new Hardware($id);
    $controlador = new ControladorSitio();
    $obtener = $hardware->obtener();
    if ($obtener == 2) {

        $sitio = $hardware->getSitio();
        $ambiente = $hardware->getAmbiente();
        $tipo = $hardware->getTipo();
        $dominio = $hardware->getDominio();
        $rti = $hardware->getRti();

        // Se cargan las opciones para el tipo de hardware 
        $opcionesTipo = ($tipo == "Host virtual") ? '<option value="Host virtual" selected>Host virtual</option>' : '<option value="Host virtual">Host virtual</option>';
        $opcionesTipo .= ($tipo == "Maquina virtual") ? '<option value="Maquina virtual" selected>Máquina virtual</option>' : '<option value="Maquina virtual">Máquina virtual</option>';
        $opcionesTipo .= ($tipo == "Hardware fisico") ? '<option value="Hardware fisico" selected>Hardware físico</option>' : '<option value="Hardware fisico">Hardware físico</option>';
        $opcionesTipo .= ($tipo == "Otro") ? '<option value="Otro" selected>Otro</option>' : '<option value="Otro">Otro</option>';

        // Se cargan las opciones para el ambiente
        $opcionesAmbiente = ($ambiente == "Produccion") ? '<option value="Produccion" selected>Producción</option>' : '<option value="Produccion">Producción</option>';
        $opcionesAmbiente .= ($ambiente == "DMZ") ? '<option value="DMZ" selected>DMZ</option>' : '<option value="DMZ">DMZ</option>';

        // Se cargan las opciones para el dominio
        $opcionesDominio = ($dominio == "CORP") ? '<option value="CORP" selected>CORP</option>' : '<option value="CORP">CORP</option>';
        $opcionesDominio .= ($dominio == "DMZ") ? '<option value="DMZ" selected>DMZ</option>' : '<option value="DMZ">DMZ</option>';
        $opcionesDominio .= ($dominio == "SANTACRUZ") ? '<option value="SANTACRUZ" selected>SANTA CRUZ</option>' : '<option value="SANTACRUZ">SANTA CRUZ</option>';

        // Se cargan las opcione para el RTI
        $opcionesRTI = ($rti == "Si") ? '<option value="Si" selected>Sí</option>' : '<option value="Si">Sí</option>';
        $opcionesRTI .= ($rti == "No") ? '<option value="No" selected>No</option>' : '<option value="No">No</option>';

        $cuerpo = '
                <input type="hidden" name="idHardware" id="idHardware" value="' . $id . '">
                <div class="form-row">
                    <label for="tipo" class="col-sm-2 col-form-label">* Tipo:</label>
                    <div class="col">
                        <select class="form-control mb-2" id="tipo" name="tipo">' . $opcionesTipo . '</select>
                    </div>
                    <label for="ambiente" class="col-sm-2 col-form-label">* Ambiente:</label>
                    <div class="col">
                        <select class="form-control mb-2" id="ambiente" name="ambiente">' . $opcionesAmbiente . '</select>
                    </div>
                </div>
                <div class="form-row">
                    <label for="sigla" class="col-sm-2 col-form-label">* Nombre corto:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2" 
                               name="sigla" id="sigla" maxlength="20" value="' . $hardware->getSigla() . '"
                               placeholder="Sigla" required>
                    </div>
                    <label for="nombre" class="col-sm-2 col-form-label">* Nombre largo:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2" 
                               name="nombre" id="nombre" maxlength="50" value="' . $hardware->getNombre() . '"
                               placeholder="Nombre" required>
                    </div>
                </div>
                <div class="form-row">
                    <label for="sucursal" class="col-sm-2 col-form-label">* Ubicación:</label>
                    <div class="col">
                        <select class="form-control mb-2" id="sucursal" name="sucursal">
                            <option value="' . $sitio->getId() . '">' . $sitio->getNombre() . '</option>
                        </select>
                    </div>
                    <label for="dominio" class="col-sm-2 col-form-label">* Dominio:</label>
                    <div class="col">
                        <select class="form-control mb-2" id="dominio" name="dominio">' . $opcionesDominio . '</select>
                    </div>
                </div>
                <div class="form-row">
                    <label for="swbase" class="col-sm-2 col-form-label">Software base:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2" 
                               name="swbase" id="swbase" maxlength="50" value="' . $hardware->getSwBase() . '"
                               placeholder="Software base">
                    </div>
                    <label for="marca" class="col-sm-2 col-form-label">Marca:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2" 
                               name="marca" id="marca" maxlength="50" value="' . $hardware->getMarca() . '"
                               placeholder="Marca">
                    </div>
                </div>
                <div class="form-row">
                    <label for="modelo" class="col-sm-2 col-form-label">Modelo:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2" 
                               name="modelo" id="modelo" maxlength="50" value="' . $hardware->getModelo() . '"
                               placeholder="Modelo">
                    </div>
                    <label for="arquitectura" class="col-sm-2 col-form-label">Arquitectura:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2" 
                               name="arquitectura" id="arquitectura" maxlength="50" value="' . $hardware->getArquitectura() . '"
                               placeholder="Arquitectura">
                    </div>
                </div>
                <div class="form-row">
                    <label for="core" class="col-sm-2 col-form-label">Core:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2" 
                               name="core" id="core" maxlength="50" value="' . $hardware->getCore() . '"
                               placeholder="Core">
                    </div>
                    <label for="procesador" class="col-sm-2 col-form-label">Procesador:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2" 
                               name="procesador" id="procesador" maxlength="50" value="' . $hardware->getProcesador() . '"
                               placeholder="Procesador">
                    </div>
                </div>
                <div class="form-row">
                    <label for="mhz" class="col-sm-2 col-form-label">Mhz:</label>
                    <div class="col">
                        <input type="number" class="form-control mb-2" 
                               name="mhz" id="mhz" min="1" value="' . $hardware->getMhz() . '"
                               placeholder="Mhz">
                    </div>
                    <label for="memoria" class="col-sm-2 col-form-label">Memoria (MB):</label>
                    <div class="col">
                        <input type="number" class="form-control mb-2" 
                               name="memoria" id="memoria" min="1" value="' . $hardware->getMemoria() . '"
                               placeholder="Memoria">
                    </div>
                </div>
                <div class="form-row">
                    <label for="disco" class="col-sm-2 col-form-label">Disco (GB):</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2" 
                               name="disco" id="disco" maxlength="50" value="' . $hardware->getDisco() . '"
                               placeholder="Disco">
                    </div>
                    <label for="raid" class="col-sm-2 col-form-label">Raid:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2" 
                               name="raid" id="raid" maxlength="50" value="' . $hardware->getRaid() . '"
                               placeholder="Raid">
                    </div>
                </div>
                <div class="form-row">
                    <label for="disco" class="col-sm-2 col-form-label">Red:</label>
                    <div class="col">
                        <input type="number" class="form-control mb-2" 
                               name="red" id="red" min="1" value="' . $hardware->getRed() . '"
                               placeholder="Red">
                    </div>
                    <label for="rti" class="col-sm-2 col-form-label">* RTI:</label>
                    <div class="col">
                        <select class="form-control mb-2" id="rti" name="rti">' . $opcionesRTI . '</select>
                    </div>
                </div>
                <div class="form-row">
                    <label for="funcion" class="col-sm-2 col-form-label">* Función: </label>
                    <div class="col">
                        <textarea class="form-control mb-2" 
                                  name="funcion" id="funcion" maxlength="50" 
                                  placeholder="Función" required>' . $hardware->getFuncion() . '</textarea>
                    </div>
                </div>';
        $boton = '<button type="submit" class="btn btn-success" id="btnModificarHardware" disabled>
                              <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $cuerpo = ControladorHTML::getAlertaOperacion($obtener, $hardware->getMensaje());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}
?>
<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3 mb-3">
        <div class="col text-left">
            <h4><i class="fas fa-microchip"></i> MODIFICAR HARDWARE</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarHardware" name="formModificarHardware" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarHardware.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarHardware.js"></script>