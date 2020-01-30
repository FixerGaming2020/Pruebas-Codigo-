<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$boton = "";
if (isset($_POST['idActivoPadre'])) {
    $id = $_POST['idActivoPadre'];
    $padre = new ActivoPadre($id);
    $controladorHijo = new ControladorActivoHijo();
    $hijos = $controladorHijo->buscar("", "Activo");
    $resultado = $padre->obtener();
    if (($resultado == 2) && (gettype($hijos) == "resource")) {

        // CARGA LOS ACTIVOS QUE ESTAN EN LA BASE DE DATOS
        $filas = "";
        $idsHijos = array_column($padre->getHijos(), "id");
        while ($hijo = sqlsrv_fetch_array($hijos, SQLSRV_FETCH_ASSOC)) {
            $check = (in_array($hijo['id'], $idsHijos)) ? "checked" : "";
            $filas .= "
            <tr>
                <td class='text-center'>
                    <input type='checkbox' id='hijos' name='hijos[]' $check value='{$hijo['id']}'>
                </td>
                <td class='align-middle'>" . utf8_encode($hijo['sigla']) . "</td>
                <td class='align-middle'>" . utf8_encode($hijo['nombre']) . "</td>
            </tr>";
        }
        $tablaHijos = '
            <div class="table-responsive">
                <table id="tbHijos" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">
                                <input type="checkbox" id="cbTodosHijos" name="cbTodosHijos">
                            </th>
                            <th>Nombre corto</th>
                            <th>Nombre largo</th>
                        </tr>
                    </thead>
                    <tbody>' . $filas . '</tbody>
                </table>
            </div>';

        $categoria = $padre->getCategoria();
        $opcCategoria = ($categoria == 'Macro procesos') ? '<option value="Macro procesos" selected>Macro procesos</option>' : '<option value="Macro procesos">Macro procesos</option>';
        $opcCategoria .= ($categoria == 'Datos/Información') ? '<option value="Datos/Información" selected>Datos/Información</option>' : '<option value="Datos/Información">Datos/Información</option>';
        $opcCategoria .= ($categoria == 'Recursos informáticos') ? '<option value="Recursos informáticos" selected>Recursos informáticos</option>' : '<option value="Recursos informáticos">Recursos informáticos</option>';
        $opcCategoria .= ($categoria == 'Servicios internos') ? '<option value="Servicios internos" selected>Servicios internos</option>' : '<option value="Servicios internos">Servicios internos</option>';
        $opcCategoria .= ($categoria == 'Servicios subcontatados') ? '<option value="Servicios subcontatados" selected>Servicios subcontatados</option>' : '<option value="Servicios subcontatados">Servicios subcontatados</option>';
        $opcCategoria .= ($categoria == 'Entorno') ? '<option value="Entorno" selected>Entorno</option>' : '<option value="Entorno">Entorno</option>';

        $cuerpo = '
            <input type="hidden" name="idActivoPadre" id="idActivoPadre" value="' . $padre->getId() . '">
            <div class="form-row">
                <label for="categoria" class="col-sm-2 col-form-label">* Categoria:</label>
                <div class="col">
                    <select class="form-control mb-2" name="categoria" id="categoria">' . $opcCategoria . '</select>
                </div>
                <label for="sigla" class="col-sm-2 col-form-label">* Nombre corto:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="sigla" id="sigla" minlength="3" maxlength="15"
                           value="' . $padre->getSigla() . '"
                           placeholder="Nombre corto del activo" required>
                </div>
            </div>
            <div class="form-row">
                <label for="nombre" class="col-sm-2 col-form-label">* Nombre largo:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" minlength="5" maxlength="50"
                           value="' . $padre->getNombre() . '"
                           placeholder="Nombre del activo" required>
                </div>
                <label class="col-sm-2 col-form-label"></label>
                <div class="col"></div>
            </div>
            <div class="form-row">
                <label for="hijos" class="col-sm-2 col-form-label">* Dependencias:</label>
                <div class="col">' . $tablaHijos . '</div>
            </div>';
        $boton = '<button type="submit" class="btn btn-success" 
                        id="btnModificarActivoPadre" disabled>
                        <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $mensaje = ($resultado != 2) ? $padre->getMensaje() : $controladorHijo->getMensaje();
        $tipo = ($resultado != 2) ? $resultado : $hijos;
        $cuerpo = ControladorHTML::getAlertaOperacion($tipo, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion($resultado, $mensaje);
}
?>
<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3 mb-3">
        <div class="col text-left">
            <h4><i class="fas fa-list"></i> MODIFICAR ACTIVO PADRE</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarActivoPadre" name="formModificarActivoPadre" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarActivoPadre.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarActivoPadre.js"></script>
