<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
require_once '../../principal/vistas/header.php';

AutoCargador::cargarModulos();

$controladorServicio = new ControladorServicio();
$servicios = $controladorServicio->buscar("", "Activo");
if (gettype($servicios) == "resource") {
    $filas = "";
    while ($servicio = sqlsrv_fetch_array($servicios, SQLSRV_FETCH_ASSOC)) {
        $filas .= "
            <tr>
                <td class='text-center'>
                    <input type='checkbox' id='servicios' name='servicios[]' value='{$servicio['id']}'>
                </td>
                <td class='align-middle'>" . utf8_encode($servicio['sigla']) . "</td>
                <td class='align-middle'>" . utf8_encode($servicio['nombre']) . "</td>
            </tr>";
    }
    $tablaServicios = '
        <div class="table-responsive">
            <table id="tbServicios" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">
                            <input type="checkbox" id="cbTodosServicios" name="cbTodosServicios">
                        </th>
                        <th>Sigla</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';

    $cuerpo = '
        <div class="form-row">
            <label for="nombre" class="col-sm-2 col-form-label text-left">* Nombre:</label>
            <div class="col">
                <input type="text" class="form-control mb-2" 
                       name="nombre" id="nombre" 
                       placeholder="Nombre del proveedor" required>
            </div>
            <label for="tipo" class="col-sm-2 col-form-label">* Tipo:</label>
            <div class="col">
                <select name="tipo" id="tipo" class="form-control mb-2">
                    <option value="Descentralización">Descentralización</option>
                    <option value="Tercerizado">Tercerizado</option>
                </select>
            </div>

        </div>
        <div class="form-row">
            <label for="correo" class="col-sm-2 col-form-label">Correo:</label>
            <div class="col">
                <input type="email" class="form-control mb-2" 
                       name="correo" id="correo" 
                       placeholder="Correo electrónico">
            </div>
            <label for="telefono" class="col-sm-2 col-form-label">Telefono:</label>
            <div class="col">
                <input type="tel" class="form-control mb-2" 
                       name="telefono" id="telefono" 
                       placeholder="Número de telefono">
            </div>
        </div>
        <div class="form-row">
            <label for="provincia" class="col-sm-2 col-form-label">* Provincia:</label>
            <div class="col">
                <input type="text" class="form-control mb-2" 
                       name="provincia" id="provincia" 
                       placeholder="Provincia" required>
            </div>
            <label for="localidad" class="col-sm-2 col-form-label">* Localidad:</label>
            <div class="col">
                <input type="text" class="form-control mb-2" 
                       name="localidad" id="localidad" 
                       placeholder="Nombre de localidad" required>
            </div>
        </div>
        <div class="form-row">
            <label for="direccion" class="col-sm-2 col-form-label">* Dirección:</label>
            <div class="col">
                <input type="text" class="form-control mb-2" 
                       name="direccion" id="direccion" 
                       placeholder="Direccion" required>
            </div>
            <label class="col-sm-2 col-form-label"></label>
            <div class="col"></div>
        </div>
        <div class="form-row">
            <label for="servicios" class="col-sm-2 col-form-label">* Servicios:</label>
            <div class="col">' . $tablaServicios . '</div>
        </div>';

    $boton = '<button type="submit" class="btn btn-success" 
                      name="btnCrearProveedor">
                      <i class="far fa-save"></i> GUARDAR
              </button>';
} else {
    $boton = "";
    $mensaje = $controladorServicio->getMensaje();
    $cuerpo = ControladorHTML::getAlertaOperacion($resultado, $mensaje);
}
?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div id="seccionSuperior" class="form-row mt-3">
            <div class="col text-left">
                <h4><i class="far fa-address-card"></i> CREAR PROVEEDOR</h4>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <form id="formCrearProveedor" name="formCrearProveedor" method="POST">
            <div class="card border-azul-clasico mt-3">
                <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
                <div class="card-body">
                    <?= $cuerpo; ?>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <?= $boton; ?>
                    <a href="FBuscarProveedor.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/CrearProveedor.js"></script>
