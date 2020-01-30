<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$boton = "";
if ($_POST['idAplicacion']) {
    $id = $_POST['idAplicacion'];
    $aplicacion = new Aplicacion($id);
    $resultado = $aplicacion->obtener();
    if ($resultado == 2) {
        $tipo = $aplicacion->getTipo();
        $tecnologia = $aplicacion->getTecnologia();
        $seguridad = $aplicacion->getSeguridad();
        $proveedor = $aplicacion->getProveedor();
        $herramienta = $aplicacion->getHerramienta();
        $lenguaje = $aplicacion->getLenguaje();
        $base = $aplicacion->getBase();
        $plataforma = $aplicacion->getPlataforma();
        $modo = $aplicacion->getModo();
        $lugar = $aplicacion->getLugar();
        $servidor = $aplicacion->getSDesarrollo();
        $delegado = $aplicacion->getEmpleado();
        $rti = $aplicacion->getRti();

        //CARGA LAS OPCIONES PARA TIPO DE SOFTWARE 
        $opcTipo = ($tipo == "Aplicación") ? '<option value="Aplicación" selected>Aplicación</option>' : '<option value="Aplicación">Aplicación</option>';
        $opcTipo .= ($tipo == "Técnico") ? '<option value="Técnico" selected>Técnico</option>' : '<option value="Técnico">Técnico</option>';

        //CARGA LAS OPCIONES PARA TECNOLOGIA
        $opcTecnologia = ($tecnologia == "No aplica") ? '<option value="No aplica" selected>No aplica</option>' : '<option value="No aplica">No aplica</option>';
        $opcTecnologia .= ($tecnologia == "Cliente-Servidor") ? '<option value="Cliente-Servidor" selected>Cliente-Servidor</option>' : '<option value="Cliente-Servidor">Cliente-Servidor</option>';
        $opcTecnologia .= ($tecnologia == "Stand Alone") ? '<option value="Stand Alone" selected>Stand Alone</option>' : '<option value="Stand Alone">Stand Alone</option>';
        $opcTecnologia .= ($tecnologia == "Web") ? '<option value="Web" selected>Web</option>' : '<option value="Web">Web</option>';
        $opcTecnologia .= ($tecnologia == "Web Service") ? '<option value="Web Service" selected>Web Service</option>' : '<option value="Web Service">Web Service</option>';

        //CARGA LAS OPCIONES PARA SEGURIDAD
        $opcSeguridad = ($seguridad == 'Active Directory') ? '<option value="Active Directory" selected>Active Directory</option>' : '<option value="Active Directory">Active Directory</option>';
        $opcSeguridad .= ($seguridad == 'Integrada') ? '<option value="Integrada" selected>Integrada</option>' : '<option value="Integrada">Integrada</option>';
        $opcSeguridad .= ($seguridad == 'Propia') ? '<option value="Propia" selected>Propia</option>' : '<option value="Propia">Propia</option>';

        //CARGA LAS OPCIONES DE RIESGO TI
        $opcRTI = ($rti == 'Si') ? '<option value="Si" selected>Si</option>' : '<option value="Si">Si</option>';
        $opcRTI .= ($rti == 'No') ? '<option value="No" selected>No</option>' : '<option value="No">No</option>';

        //CARGAN LAS OPCIONES DINAMICAS

        $opcProveedor = ($proveedor) ? '<option value="' . $proveedor->getId() . '">' . $proveedor->getNombre() . '</option>' : '';
        $opcHerramienta = ($herramienta) ? '<option value="' . $herramienta->getId() . '">' . $herramienta->getNombre() . '</option>' : '';
        $opcLenguaje = ($lenguaje) ? '<option value="' . $lenguaje->getId() . '">' . $lenguaje->getNombre() . '</option>' : '';
        $opcBase = ($base) ? '<option value="' . $base->getId() . '">' . $base->getNombre() . '</option>' : '';
        $opcPlataforma = ($plataforma) ? '<option value="' . $plataforma->getId() . '">' . $plataforma->getNombre() . '</option>' : '';
        $opcServidor = ($servidor) ? '<option value="' . $servidor->getId() . '">' . $servidor->getNombre() . '</option>' : '';
        $opcDelegado = ($delegado) ? '<option value="' . $delegado->getId() . '">' . $delegado->getNombre() . '</option>' : '';
        $cuerpo = '
            <input type="hidden" name="idAplicacion" id="idAplicacion" value="' . $aplicacion->getId() . '"/>
            <div class="form-row">
                <label for="tipo" class="col-sm-2 col-form-label"
                       title="Tipo de software: campo obligatorio">* Tipo de software:</label>
                <div class="col">
                    <select class="form-control mb-2" id="tipo" name="tipo">' . $opcTipo . '</select>
                </div>
                <label for="tecnologia" class="col-sm-2 col-form-label"
                       title="Teconologia: campo obligatorio">* Técnologia:</label>
                <div class="col">
                    <select class="form-control mb-2" id="tecnologia" name="tecnologia">' . $opcTecnologia . '</select>
                </div>
            </div>
            <div class="form-row">
                <label for="sigla" class="col-sm-2 col-form-label"
                       title="Nombre corto: campo obligatorio">* Nombre corto:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="sigla" id="sigla" minlength="3" maxlength="20"
                           value="' . $aplicacion->getSigla() . '"
                           placeholder="Nombre corto" required>
                </div>
                <label for="nombre" class="col-sm-2 col-form-label"
                       title="Nombre largo: campo obligatorio">* Nombre largo:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" minlength="3" maxlength="50"
                           value="' . $aplicacion->getNombre() . '"
                           placeholder="Nombre largo" required>
                </div>
            </div>
            <div class="form-row">
                <label for="seguridad" class="col-sm-2 col-form-label"
                       title="Seguridad: campo obligatorio">* Seguridad:</label>
                <div class="col">
                    <select class="form-control mb-2" id="seguridad" name="seguridad">' . $opcSeguridad . '</select>
                </div>
                <label for="proveedor" class="col-sm-2 col-form-label"
                       title="Proveedor: campo no obligatorio">Proveedor:</label>
                <div class="col">
                    <select class="form-control mb-2" id="proveedor" name="proveedor">' . $opcProveedor . '</select>
                </div>
            </div>
            <div class="form-row">
                <label for="herramienta" class="col-sm-2 col-form-label"
                       title="Herramienta de desarrollo: campo no obligatorio">Herramienta:</label>
                <div class="col">
                    <select class="form-control mb-2" id="herramienta" name="herramienta">' . $opcHerramienta . '</select>
                </div>
                <label for="lenguaje" class="col-sm-2 col-form-label"
                       title="Lenguaje de programación: campo no obligatorio">Lenguaje:</label>
                <div class="col">
                    <select class="form-control mb-2" id="lenguaje" name="lenguaje">' . $opcLenguaje . '</select>
                </div>
            </div>
            <div class="form-row">
                <label for="base" class="col-sm-2 col-form-label"
                       title="Base de datos: campo no obligatorio">Base de datos:</label>
                <div class="col">
                    <select class="form-control mb-2" id="base" name="base">' . $opcBase . '</select>
                </div>
                <label for="plataforma" class="col-sm-2 col-form-label"
                       title="Plataforma de sistema operativo: campo obligatorio">* Plataforma SO:</label>
                <div class="col">
                    <select class="form-control mb-2" id="plataforma" name="plataforma" required>' . $opcPlataforma . '</select>
                </div>
            </div>
            <div class="form-row">
                <label for="modo" class="col-sm-2 col-form-label"
                       title="Modo de procesamiento: campo obligatorio">* Modo proc. :</label>
                <div class="col">
                    <select class="form-control mb-2" id="modo" name="modo" required>
                        <option value="' . $modo->getId() . '">' . $modo->getNombre() . '</option>
                    </select>
                </div>
                <label for="lugar" class="col-sm-2 col-form-label"
                       title="Lugar de procesamiento: campo obligatorio">* Lugar proc. :</label>
                <div class="col">
                    <select class="form-control mb-2" id="lugar" name="lugar">
                        <option value="' . $lugar->getId() . '">' . $lugar->getNombre() . '</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <label for="sdesarrollo" class="col-sm-2 col-form-label"
                       title="Servidor en desarrollo: campo no obligatorio">Servidor desarrollo:</label>
                <div class="col">
                    <select class="form-control mb-2" id="sdesarrollo" name="sdesarrollo">' . $opcServidor . '</select>
                </div>
                <label for="pdesarrollo" class="col-sm-2 col-form-label"
                       title="Puerto en desarrollo: campo no obligatorio">Puerto desarrollo:</label>
                <div class="col">
                    <input type="number" class="form-control mb-2" 
                           name="pdesarrollo" id="pdesarrollo" min="1"
                           value="' . $aplicacion->getPDesarrollo() . '"
                           placeholder="Puerto de desarrollo">
                </div>
            </div>
            <div class="form-row">
                <label for="delegado" class="col-sm-2 col-form-label"
                       title="Delegado: campo no obligatorio">Delegado:</label>
                <div class="col">
                    <select class="form-control mb-2" id="delegado" name="delegado">' . $opcDelegado . '</select>
                </div>
                <label for="rti" class="col-sm-2 col-form-label"
                       title="Riesgo de TI: campo obligatorio">RTI:</label>
                <div class="col">
                    <select class="form-control mb-2" id="rti" name="rti">' . $opcRTI . '</select>
                </div>
            </div>
            <div class="form-row">
                <label for="descripcion" class="col-sm-2 col-form-label"
                       title="Descripción: campo obligatorio">* Descripción:</label>
                <div class="col">
                    <textarea class="form-control mb-2" 
                              name="descripcion" id="descripcion"
                              rows="5" minlength="10" maxlength="500"
                              placeholder="Descripción de la aplicación" required>' . $aplicacion->getDescripcion() . '</textarea>
                </div>
            </div>';
        $boton = '<button type="submit" class="btn btn-success" 
                    id="btnModificarAplicacion" disabled>
                    <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $mensaje = $aplicacion->getMensaje();
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
            <h4><i class="fas fa-desktop"></i> MODIFICAR APLICACIÓN</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarAplicacion" name="formModificarAplicacion" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarPPAplicacion.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarPPAplicacion.js"></script>


