<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$boton = "";
if ($_POST['idPerfil']) {
    $id = $_POST['idPerfil'];
    $perfil = new Perfil($id);
    $resultado = $perfil->obtener();
    if ($resultado == 2) {
        $menuesPerfil = $perfil->getPermisos();
        $permisosPerfil = array();
        foreach ($menuesPerfil as $menu) {
            $permisosPerfil[] = $menu[0];
            $submenuesPerfil = $menu[2];
            foreach ($submenuesPerfil as $submenu) {
                $permisosPerfil[] = $submenu[0];
            }
        }
        $controlador = new ControladorPermiso();
        $permisos = $controlador->listar();
        if (gettype($permisos) == "resource") {
            $filas = "";
            while ($permiso = sqlsrv_fetch_array($permisos, SQLSRV_FETCH_ASSOC)) {
                $check = (in_array($permiso['id'], $permisosPerfil)) ? "checked" : "";
                $filas .= "
                    <tr>
                        <td class='text-center align-middle'>
                            <input type='checkbox' id='permisos' name='permisos[]' value='{$permiso['id']}' $check>
                        </td>
                        <td>" . utf8_encode($permiso['titulo']) . "</td>
                        <td>" . utf8_encode($permiso['nivel']) . "</td>
                        <td>" . utf8_encode($permiso['padre']) . "</td>
                        <td>" . utf8_encode($permiso['link']) . "</td>
                    </tr>";
            }
            $cuerpo = '
                <input type="hidden" id="idPerfil" name="idPerfil" value="' . $perfil->getId() . '"/>
                <div class="form-row">
                    <label for="nombre" class="col-sm-2 col-form-label"
                           title="Nombre: campo obligatorio">* Nombre:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2" 
                               name="nombre" id="nombre" 
                               minlength="3" maxlength="50"
                               value="' . $perfil->getNombre() . '"
                               placeholder="Nombre del perfil" required>
                    </div>
                </div>
                <div class="form-row">
                    <label for="descripcion" class="col-sm-2 col-form-label"
                           title="Descripción: campo obligatorio">* Descripción:</label>
                    <div class="col">
                        <textarea class="form-control mb-2" 
                               name="descripcion" id="descripcion" 
                               minlength="10" maxlength="300" rows="3"
                               placeholder="Descripción del perfil" required>' . $perfil->getDescripcion() . '</textarea>
                    </div>
                </div>
                <div class="form-row">
                    <label for="nombre" class="col-sm-2 col-form-label"
                           title="Permisos: campo obligatorio">* Permisos:</label>
                    <div class="col">
                        <table class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle">
                                        <input type="checkbox" name="cbTodosPermisos" id="cbTodosPermisos" title="Seleccionar todos los permisos">
                                    </th>
                                    <th>Nombre</th>
                                    <th>Nivel</th>
                                    <th>Padre</th>
                                    <th>Referencia</th>
                                </tr>
                            </thead>
                            <tbody>' . $filas . ' </tbody>
                        </table>
                    </div>
                </div>';
            $boton = '<button type="submit" class="btn btn-success" 
                              id="btnModificarPerfil" name="btnModificarPerfil" disabled>
                              <i class="far fa-save"></i> GUARDAR</button>';
        } else {
            $mensaje = $controlador->getMensaje();
            $cuerpo = ControladorHTML::getAlertaOperacion($permisos, $mensaje);
        }
    } else {
        $mensaje = $perfil->getMensaje();
        $cuerpo = ControladorHTML::getAlertaOperacion($resultado, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::getAlertaOperacion(0, $mensaje);
}
?>
<div class="container-fluid">
    <div id="seccionSuperior" class="form-row mt-3 mb-3">
        <div class="col text-left">
            <h4><i class="fas fa-user-friends"></i> MODIFICAR PERFIL</h4>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <form id="formModificarPerfil" name="formModificarPerfil" method="POST">
        <div class="card border-azul-clasico mt-3">
            <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
            <div class="card-body">
                <?= $cuerpo; ?>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <?= $boton; ?>
                <a href="FBuscarPerfil.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="../js/ModificarPerfil.js"></script>