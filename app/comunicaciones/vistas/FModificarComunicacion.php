<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$boton = "";
if ($_POST['idComunicacion']) {
    $id = $_POST['idComunicacion'];
    $comunicacion = new Comunicacion($id);
    $resultado = $comunicacion->obtener();
    if ($resultado == 2) {
        $gerencia = $comunicacion->getGerencia();
        $delegado = $comunicacion->getDelegado();
        $sitio = $comunicacion->getUbicacion();
        $proveedor = $comunicacion->getProveedor();
        $cuerpo = '
            <input type="hidden" name="idComunicacion" id="idComunicacion" value="' . $comunicacion->getId() . '">
            <div class="form-row">
                <label for="sigla" class="col-sm-2 col-form-label">* Nombre corto:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="sigla" id="sigla" maxlength="20" 
                           value="' . $comunicacion->getSigla() . '"
                           placeholder="Nombre corto" required>
                </div>
                <label for="nombre" class="col-sm-2 col-form-label">* Nombre largo:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" maxlength="50"
                           value="' . $comunicacion->getNombre() . '"
                           placeholder="Nombre largo" required>
                </div>
            </div>
            <div class="form-row">
                <label for="gerencia" class="col-sm-2 col-form-label">* Gerencia:</label>
                <div class="col">
                    <select class="form-control mb-2" name="gerencia" id="gerencia">
                        <option value="' . $gerencia->getId() . '">' . $gerencia->getNombre() . '</option>
                    </select>
                </div>
                <label for="delegado" class="col-sm-2 col-form-label">* Delegado:</label>
                <div class="col">
                    <select class="form-control mb-2" name="delegado" id="delegado">
                        <option value="' . $delegado->getId() . '">' . $delegado->getNombre() . '</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <label for="ubicacion" class="col-sm-2 col-form-label">* Ubicación:</label>
                <div class="col">
                    <select class="form-control mb-2" name="ubicacion" id="ubicacion">
                        <option value="' . $sitio->getId() . '">' . $sitio->getNombre() . '</option>
                    </select>
                </div>
                <label for="proveedor" class="col-sm-2 col-form-label">* Proveedor:</label>
                <div class="col">
                    <select class="form-control mb-2" name="proveedor" id="proveedor">
                        <option value="' . $proveedor->getId() . '">' . $proveedor->getNombre() . '</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <label for="cantidad" class="col-sm-2 col-form-label">* Cantidad:</label>
                <div class="col">
                    <input type="number" class="form-control mb-2" 
                           name="cantidad" id="cantidad" min="1"
                           value="' . $comunicacion->getCantidad() . '"
                           placeholder="Cantidad" required>
                </div>
                <label for="rti" class="col-sm-2 col-form-label">* RTI:</label>
                <div class="col">
                    <select class="form-control mb-2" name="rti" id="rti">
                        <option value="Si">Si</option>
                        <option value="No">No</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <label for="cantidad" class="col-sm-2 col-form-label">* Descripción:</label>
                <div class="col">
                    <textarea class="form-control mb-2" name="descripcion" id="descripcion"
                              placeholder="Decripción">' . $comunicacion->getDescripcion() . '</textarea>
                </div>
            </div>';
        $boton = '
            <button type="submit" class="btn btn-success" 
                    id="btnModificarComunicacion" disabled>
                    <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $cuerpo = ControladorHTML::getAlertaOperacion($resultado, $comunicacion->getMensaje());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}
?>
<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3 mb-3">
        <div class="col text-left">
            <h4><i class="fas fa-broadcast-tower"></i> MODIFICAR COMUNICACIÓN</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarComunicacion" name="formModificarComunicacion" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarComunicacion.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarComunicacion.js"></script>