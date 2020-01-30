<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$boton = "";
if (isset($_POST['idGerencia'])) {
    $id = $_POST['idGerencia'];
    $gerencia = new Gerencia($id);
    $resultado = $gerencia->obtener();
    if ($resultado == 2) {
        $jefe = $gerencia->getJefe();
        $cuerpo = '
            <input type="hidden" name="idGerencia" id="idGerencia" value="' . $gerencia->getId() . '">
            <div class="form-row">
                <label for="nombre" class="col-sm-2 col-form-label text-left">* Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" 
                           value="' . $gerencia->getNombre() . '"
                           placeholder="Nombre de la gerencia">
                </div>
                <label for="jefe" class="col-sm-2 col-form-label text-left">* Jefe:</label>
                <div class="col">
                    <select id="jefe" name="jefe" class="form-control mb-2">
                        <option value="' . $jefe->getId() . '">' . $jefe->getNombre() . '</option>
                    </select>
                </div>
            </div>';
        $boton = '
            <button type="submit" class="btn btn-success" 
                    id="btnModificarGerencia" disabled>
                    <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $cuerpo = ControladorHTML::getAlertaOperacion($resultado, $gerencia->getMensaje());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $formulario = ControladorHTML::getAlertaOperacion(0, $mensaje);
}
?>
<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3 mb-3">
        <div class="col text-left">
            <h4><i class="fas fa-sitemap"></i> MODIFICAR GERENCIA</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarGerencia" name="formModificarGerencia" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarGerencia.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarGerencia.js"></script>