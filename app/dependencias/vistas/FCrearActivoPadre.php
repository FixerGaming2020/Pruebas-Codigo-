<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
require_once '../../principal/vistas/header.php';

AutoCargador::cargarModulos();

$controladorHijo = new ControladorActivoHijo();
$hijos = $controladorHijo->buscar("", "Activo");
if (gettype($hijos) == "resource") {
    $filas = "";
    while ($hijo = sqlsrv_fetch_array($hijos, SQLSRV_FETCH_ASSOC)) {
        $filas .= "
            <tr>
                <td class='text-center'>
                    <input type='checkbox' id='hijos' name='hijos[]' value='{$hijo['id']}'>
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

    $cuerpo = '
        <div class="form-row">
            <label for="categoria" class="col-sm-2 col-form-label">* Categoria:</label>
            <div class="col">
                <select class="form-control mb-2" name="categoria" id="categoria">
                    <option value="Macro procesos">Macro procesos</option>
                    <option value="Datos/Información">Datos/Información</option>
                    <option value="Recursos informáticos">Recursos informáticos</option>
                    <option value="Servicios internos">Servicios internos</option>
                    <option value="Servicios subcontatados">Servicios subcontatados</option>
                    <option value="Entorno">Entorno</option>
                </select>
            </div>
            <label for="sigla" class="col-sm-2 col-form-label">* Nombre corto:</label>
            <div class="col">
                <input type="text" class="form-control mb-2" 
                       name="sigla" id="sigla" minlength="3" maxlength="15"
                       placeholder="Nombre corto del activo" required>
            </div>
        </div>
        <div class="form-row">
            <label for="nombre" class="col-sm-2 col-form-label">* Nombre largo:</label>
            <div class="col">
                <input type="text" class="form-control mb-2" 
                       name="nombre" id="nombre" minlength="5" maxlength="50"
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
                      name="btnCrearActivoPadre">
                      <i class="far fa-save"></i> GUARDAR
              </button>';
} else {
    $boton = "";
    $mensaje = $controladorHijo->getMensaje();
    $cuerpo = ControladorHTML::getAlertaOperacion($resultado, $mensaje);
}
?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div id="seccionSuperior" class="form-row mt-3 mb-3">
            <div class="col text-left">
                <h4><i class="fas fa-list"></i> CREAR ACTIVO PADRE</h4>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <form id="formCrearActivoPadre" name="formCrearActivoPadre" method="POST">
            <div class="card border-azul-clasico mt-3">
                <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
                <div class="card-body"><?= $cuerpo; ?></div>
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
</div>
<script type="text/javascript" src="../js/CrearActivoPadre.js"></script>