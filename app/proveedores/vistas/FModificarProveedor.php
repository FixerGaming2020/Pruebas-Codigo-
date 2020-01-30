<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$boton = "";
if (isset($_POST['idProveedor'])) {
    $proveedor = new Proveedor($_POST['idProveedor']);
    $controladorServicio = new ControladorServicio();
    $servicios = $controladorServicio->buscar("", "Activo");
    $resultado = $proveedor->obtener();
    if (($resultado == 2) && (gettype($servicios) == "resource")) {

        // CARGA LOS SERVICIOS ACTIVOS QUE ESTAN EN LA BASE DE DATOS
        $filas = "";
        $idsServicios = array_column($proveedor->getServicios(), "id");
        while ($servicio = sqlsrv_fetch_array($servicios, SQLSRV_FETCH_ASSOC)) {
            $check = (in_array($servicio['id'], $idsServicios)) ? "checked" : "";
            $filas .= "
            <tr>
                <td class='text-center'>
                    <input type='checkbox' id='servicios' name='servicios[]' $check value='{$servicio['id']}'>
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

        $tipo = $proveedor->getTipo();

        $opcionesTipo = ($tipo == "Descentralización") ? '<option value="Descentralización" selected>Descentralización</option>' : '<option value="Descentralización">Descentralización</option>';
        $opcionesTipo .= ($tipo == "Tercerizado") ? '<option value="Tercerizado" selected>Tercerizado</option>' : '<option value="Tercerizado">Tercerizado</option>';

        // FORMULARIO DE MODIFICACION DEL PROVEEDOR
        $cuerpo = '
            <input type="hidden" name="idProveedor" id="idProveedor" value="' . $proveedor->getId() . '">
            <div class="form-row">
                <label for="nombre" class="col-sm-2 col-form-label text-left">* Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" 
                           value="' . $proveedor->getNombre() . '"
                           placeholder="Nombre del proveedor" required>
                </div>
                <label for="tipo" class="col-sm-2 col-form-label">* Tipo:</label>
                <div class="col">
                    <select name="tipo" id="tipo" class="form-control mb-2">' . $opcionesTipo . '</select>
                </div>

            </div>
            <div class="form-row">
                <label for="correo" class="col-sm-2 col-form-label">Correo:</label>
                <div class="col">
                    <input type="email" class="form-control mb-2" 
                           name="correo" id="correo" 
                           value="' . $proveedor->getCorreo() . '"
                           placeholder="Correo electrónico">
                </div>
                <label for="telefono" class="col-sm-2 col-form-label">Telefono:</label>
                <div class="col">
                    <input type="tel" class="form-control mb-2" 
                           name="telefono" id="telefono" 
                           value="' . $proveedor->getTelefono() . '"
                           placeholder="Número de telefono">
                </div>
            </div>
            <div class="form-row">
                <label for="provincia" class="col-sm-2 col-form-label">* Provincia:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="provincia" id="provincia" 
                           value="' . $proveedor->getProvincia() . '"
                           placeholder="Provincia" required>
                </div>
                <label for="localidad" class="col-sm-2 col-form-label">* Localidad:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="localidad" id="localidad" 
                           value="' . $proveedor->getLocalidad() . '"
                           placeholder="Nombre de localidad" required>
                </div>
            </div>
            <div class="form-row">
                <label for="direccion" class="col-sm-2 col-form-label">* Dirección:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="direccion" id="direccion" 
                           value="' . $proveedor->getDireccion() . '"
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
                        id="btnModificarProveedor" disabled>
                        <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $mensaje = ($resultado != 2) ? $proveedor->getMensaje() : $controladorServicio->getMensaje();
        $tipo = ($resultado != 2) ? $resultado : $servicios;
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
            <h4><i class="far fa-address-card"></i> MODIFICAR PROVEEDOR</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <div id="seccionCentral">
        <form id="formModificarProveedor" name="formModificarProveedor" method="POST">
            <div class="card mt-3 ">
                <div class="card-header text-left bg-azul-clasico text-white">Formulario de modificación</div>
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
<script type="text/javascript" src="../js/ModificarProveedor.js"></script>