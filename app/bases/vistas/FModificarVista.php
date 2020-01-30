<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$boton = "";
if (isset($_POST['idVista'])) {
    $id = $_POST['idVista'];
    $vista = new Vista($id);
    $resultado = $vista->obtener();
    if ($resultado == 2) {

        $fechaProceso = date_format($vista->getFecha(), 'd/m/Y');
        $consulta = $vista->getConsulta();
        $opcionesConsulta = ($consulta = "DESCONOCIDA") ? '<option value="DESCONOCIDA" selected>Desconocida</option>' : '<option value="DESCONOCIDA">Desconocida</option>';
        $opcionesConsulta .= ($consulta = "Interna") ? '<option value="Interna" selected>Interna</option>' : '<option value="Interna">Interna</option>';
        $opcionesConsulta .= ($consulta = "Externa") ? '<option value="Externa" selected>Externa</option>' : '<option value="Externa">Externa</option>';
        $opcionesConsulta .= ($consulta = "Combinada") ? '<option value="Combinada" selected>Combinada</option>' : '<option value="Combinada">Combinada</option>';

        $cuerpo = '
            <input type="hidden" name="idVista" id="idVista" value="' . $vista->getId() . '">
            <div class="form-row">
                <label for="sigla" class="col-sm-2 col-form-label">Base de datos:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" value="' . utf8_encode($vista->getBase()) . '" disabled>
                </div>
                <label for="nombre" class="col-sm-2 col-form-label">Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" value="' . $vista->getNombre() . '" disabled>
                </div>
            </div>
            <div class="form-row">
                <label for="sigla" class="col-sm-2 col-form-label">Fecha de proceso:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" value="' . $fechaProceso . '" disabled>
                </div>
                <label for="nombre" class="col-sm-2 col-form-label">Tipo de consulta:</label>
                <div class="col">
                    <select class="form-control mb-2" name="tipo" id="tipo">
                        <option value="DESCONOCIDA">Desconocida</option>
                        <option value="Interna">Interna</option>
                        <option value="Externa">Externa</option>
                        <option value="Combinada">Combinada</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <label for="descripcion" class="col-sm-2 col-form-label">Descripción:</label>
                <div class="col">
                    <textarea class="form-control mb-2"
                              maxlength="500" pattern="[A-Za-zÁÉÍÓÚÑáéíóúñ.,:()=/0-9 ]{0, 500}"
                              title="Descripciión: longitud máxima de 500"
                              placeholder="Descripción de la vista"
                              name="descripcion" id="descripcion">' . $vista->getDescripcion() . '</textarea>
                </div>
            </div>';
        $boton = '<button type="submit" class="btn btn-success" 
                          id="btnModificarVista" disabled>
                          <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $cuerpo = ControladorHTML::getAlertaOperacion($resultado, $vista->getMensaje());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}
?>
<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3 mb-3">
        <div class="col text-left">
            <h4><i class="fas fa-database"></i> MODIFICAR VISTA</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarVista" name="formModificarVista" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarVista.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarVista.js"></script>