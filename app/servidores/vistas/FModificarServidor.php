<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$formulario = $boton = "";
if (isset($_POST['idServidor'])) {
    $controlador = new ControladorServidor();
    $id = $_POST['idServidor'];
    $servidor = new Servidor($id);

    $resultado = $servidor->obtener();
    if ($resultado == 2) {
        $ambiente = ($servidor->getAmbiente() == 1) ? '<option value="Produccion" selected>Producción</option>' : '<option value="Produccion">Producción</option>';
        $ambiente .= ($servidor->getAmbiente() == 2) ? '<option value="Test" selected>Test</option>' : '<option value="Test">Test</option>';
        $ambiente .= ($servidor->getAmbiente() == 3) ? '<option value="Desarrollo" selected>Desarrollo</option>' : '<option value="Desarrollo">Desarrollo</option>';

        $tipo = ($servidor->getTipo() == 1) ? '<option value="Aplicaciones" selected>Aplicaciones</option>' : '<option value="Aplicaciones">Aplicaciones</option>';
        $tipo .= ($servidor->getTipo() == 2) ? '<option value="Base de datos" selected>Base de datos</option>' : '<option value="Base de datos">Base de datos</option>';
        $tipo .= ($servidor->getTipo() == 3) ? '<option value="Ambas" selected>Ambas</option>' : '<option value="Ambas">Ambos</option>';

        $cuerpo = '
            <input type="hidden" name="idServidor" id="idServidor" value="' . $id . '">
            <div class="form-row">
                <label for="ip" class="col-sm-2 col-form-label text-left">* IP:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="ip" id="ip" 
                           value="' . $servidor->getIp() . '"
                           placeholder="IP del servidor">
                </div>
                <label for="nombre" class="col-sm-2 col-form-label text-left">* Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" 
                           value="' . $servidor->getNombre() . '"
                           placeholder="Nombre del servidor">
                </div>
            </div>
            <div class="form-row">
                <label for="ambiente" class="col-sm-2 col-form-label text-left">* Ambiente:</label>
                <div class="col">
                    <select id="ambiente" name="ambiente" class="form-control mb-2" required>' . $ambiente . '</select>
                </div>
                <label for="tipo" class="col-sm-2 col-form-label text-left">* Tipo:</label>
                <div class="col">
                    <select id="tipo" name="tipo" class="form-control mb-2" required>' . $tipo . '</select>
                </div>
            </div>
            <div class="form-row">
                <label for="descripcion" class="col-sm-2 col-form-label text-left">* Descripción:</label>
                <div class="col">
                    <textarea class="form-control mb-2" id="descripcion" name="descripcion" placeholder="Descripción del servidor" required>' . $servidor->getDescripcion() . '</textarea>
                </div>
            </div>';
        $boton = '<button type="submit" class="btn btn-success" id="btnModificarServidor" disabled><i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $cuerpo = ControladorHTML::getAlertaOperacion($resultado, $controlador->getMensaje());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}
?>
<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3 mb-3">
        <div class="col text-left">
            <h4><i class="fas fa-server"></i> MODIFICAR SERVIDOR</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <div id="seccionCentral">
        <form id="formModificarServidor" name="formModificarServidor" method="POST">
            <div class="card mt-3 ">
                <div class="card-header text-left bg-azul-clasico text-white">Formulario de modificación</div>
                <div class="card-body">
                    <?= $cuerpo; ?>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <?= $boton; ?>
                    <a href="FBuscarServidor.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/ModificarServidor.js"></script>