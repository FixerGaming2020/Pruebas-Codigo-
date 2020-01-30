<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$boton = "";
if ($_POST['idFirewall']) {
    $firewall = new Firewall($_POST['idFirewall']);
    $resultado = $firewall->obtener();
    if ($resultado == 2) {
        $sucursal = $firewall->getSitio();
        $cuerpo = '
            <input type="hidden" name="idFirewall" id="idFirewall" value="' . $firewall->getId() . '">
            <div class="form-row">
                <label for="nombre" class="col-sm-2 col-form-label">* Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" 
                           value="' . $firewall->getNombre() . '"
                           placeholder="Nombre del firewall" required>
                </div>
                <label for="marca" class="col-sm-2 col-form-label">* Marca:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="marca" id="marca"
                           value="' . $firewall->getMarca() . '"
                           placeholder="Nombre de la marca" required>
                </div>
            </div>
            <div class="form-row">
                <label for="modelo" class="col-sm-2 col-form-label">* Modelo:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="modelo" id="modelo" maxlength="50"
                           value="' . $firewall->getModelo() . '"
                           placeholder="Modelo" required>
                </div>
                <label for="nroSerie" class="col-sm-2 col-form-label">* Nro Serie:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nroSerie" id="nroSerie" maxlength="50"
                           value="' . $firewall->getNroSerie() . '"
                           placeholder="Número de serie" required>
                </div>
            </div>
            <div class="form-row">
                <label for="version" class="col-sm-2 col-form-label">* Versión:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="version" id="version" maxlength="50"
                           value="' . $firewall->getVersion() . '"
                           placeholder="Versión" required>
                </div>
                <label for="ip" class="col-sm-2 col-form-label">* IP:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="ip" id="ip" maxlength="15"
                           value="' . $firewall->getIp() . '"
                           placeholder="IP" required>
                </div>
            </div>
            <div class="form-row">
                <label for="sucursal" class="col-sm-2 col-form-label">* Sucursal:</label>
                <div class="col">
                    <select class="form-control mb-2" id="sucursal" name="sucursal">
                         <option value="' . $sucursal->getId() . '">' . $sucursal->getNombre() . '</option>
                    </select>
                </div>
                <label class="col-sm-2 col-form-label"></label>
                <div class="col"></div>
            </div>';
        $boton = '<button type="submit" class="btn btn-success" id="btnModificarFirewall" disabled>
                    <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $cuerpo = ControladorHTML::getAlertaOperacion($resultado, $firewall->getMensaje());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}
?>

<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3 mb-3">
        <div class="col text-left">
            <h4><i class="fas fa-fire-alt"></i> MODIFICAR FIREWALL</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarFirewall" name="formModificarFirewall" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarFirewall.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarFirewall.js"></script>

