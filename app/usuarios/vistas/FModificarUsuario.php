<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$boton = "";
if ($_POST['idUsuario']) {
    $legajo = $_POST['idUsuario'];
    $usuario = new Usuario($legajo);
    $resultado = $usuario->obtener();
    if ($resultado == 2) {
        $perfil = $usuario->getPerfil();
        $cuerpo = '
            <input type="hidden" name="legajoOriginal" id="legajoOriginal" value="' . $usuario->getId() . '">
            <div class="form-row">
                <label for="legajo" class="col-sm-2 col-form-label">* Legajo:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="legajo" id="legajo" 
                           maxlength="10" pattern="[0-9A-Z]{4,10}"
                           value="' . $usuario->getId() . '"
                           placeholder="Legajo del usuario" required>
                </div>
                <label for="nombre" class="col-sm-2 col-form-label">* Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre"
                           value="' . $usuario->getNombre() . '"
                           placeholder="Nombre del usuario" required>
                </div>
            </div>
            <div class="form-row">
                <label for="perfil" class="col-sm-2 col-form-label text-left">* Perfil:</label>
                <div class="col">
                    <select class="form-control mb-2" id="perfil" name="perfil">
                        <option value="' . $perfil->getId() . '">' . $perfil->getNombre() . '</option>
                    </select>
                </div>
                <label class="col-sm-2 col-form-label"></label>
                <div class="col"></div>
            </div>';
        $boton = '<button type="submit" class="btn btn-success" 
                              id="btnModificarUsuario" disabled>
                              <i class="far fa-save"></i> GUARDAR</button>';
    } else {
        $cuerpo = ControladorHTML::getAlertaOperacion($resultado, $usuario->getMensaje());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}
?>
<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3 mb-3">
        <div class="col text-left">
            <h4><i class="fas fa-user-lock"></i> MODIFICAR USUARIO</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarUsuario" name="formModificarUsuario" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarUsuario.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarUsuario.js"></script>

