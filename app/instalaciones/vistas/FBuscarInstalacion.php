<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div id="contenido">
        <div class="container-fluid">
            <div id="seccionSuperior" class="form-row mt-3">
                <div class="col text-left">
                    <h4><i class="fas fa-code-branch"></i> BUSCAR INSTALACIÓN</h4>
                </div>
            </div>
            <div class="mt-3 mb-4">
                <form method="POST" id="formBuscarInstalacion" name="formBuscarInstalacion">
                    <input type="hidden" name="peticion" id="peticion">
                    <div class="card border-azul-clasico">
                        <div class="card-header bg-azul-clasico text-white">Formulario de búsqueda</div>
                        <div class="card-body">
                            <div class="form-row">
                                <label for="nombre" class="col-2 col-form-label text-left">Nombre:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="nombre" id="nombre" 
                                           maxlength="9" pattern="[A-Za-z0-9]{1,9}"
                                           title="Nombre de la instalacion: campo no obligatorio"
                                           placeholder="Nombre de la instalación">
                                </div>
                                <label for="estado" class="col-2 col-form-label text-left">* Estado:</label>
                                <div class="col">
                                    <select id="estado" name="estado" class="form-control mb-2" required>
                                        <option value="Activa">Activa</option>
                                        <option value="Inactiva">Inactiva</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col text-right">
                            <button type="submit" class="btn btn-success" name="btnBuscarInstalacion">
                                <i class="fas fa-search"></i>  BUSCAR</button>
                            <a href="FCrearInstalacion.php" title="Ir al formulario de creación">
                                <button type="button" class="btn btn-outline-info">
                                    <i class="fas fa-plus"></i> CREAR
                                </button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <br>
            <div id="seccionInferior" class="mt-4 mb-2"></div>
        </div>
        <div class="modal fade" id="ModalDatosInstalacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg border-azul-clasico">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center"><i class='fas fa-info-circle'></i> INFORMACIÓN BÁSICA</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <label for="mdISigla" class="col-sm-2 col-form-label">Nombre corto:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdiSigla" id="mdiSigla" readonly>
                            </div>
                            <label for="mdiNombre" class="col-sm-2 col-form-label">Nombre largo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdiNombre" id="mdiNombre" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdiGerencia" class="col-sm-2 col-form-label">Gerencia:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdiGerencia" id="mdiGerencia" readonly>
                            </div>
                            <label for="mdiLegajo" class="col-sm-2 col-form-label">Legajo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdiLegajo" id="mdiLegajo" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdiResponsable" class="col-sm-2 col-form-label">Responsable:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdiResponsable" id="mdiResponsable" readonly>
                            </div>
                            <label for="mdiSitio" class="col-sm-2 col-form-label">Ubicación:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdiSitio" id="mdiSitio" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdiPlataforma" class="col-sm-2 col-form-label">Plataforma:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdiPlataforma" id="mdiPlataforma" readonly>
                            </div>
                            <label for="mdiRTI" class="col-sm-2 col-form-label">RTI:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdiRTI" id="mdiRTI" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdiDescripcion" class="col-sm-2 col-form-label">Descripción:</label>
                            <div class="col">
                                <textarea type="text" class="form-control mb-2" 
                                          name="mdiDescripcion" id="mdiDescripcion" readonly></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type='submit' class='btn btn-outline-secondary' data-dismiss="modal" value='Aceptar'>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ModalCambioEstadoInstalacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg border-azul-clasico">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center" id="mceiTitulo"></h4>
                    </div>
                    <div class="modal-body" id="mceiCuerpo">
                        <form id="formCambiarEstadoInstalacion" name="formCambiarEstadoInstalacion" method="POST">
                            <input type="hidden" name="mceiAccion" id="mceiAccion">
                            <input type="hidden" name="mceiIdInstalacion" id="mceiIdInstalacion">
                            <div class="form-row">
                                <b><p id="mceiNombre" name="mceiNombre"></p></b>
                                <p>&nbsp;Presione <b>GUARDAR</b> para efectuar la operación.</p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"
                                name="btnCambiarEstadoInstalacion" id="btnCambiarEstadoInstalacion">
                            <i class="far fa-save"></i> GUARDAR</button>
                        <button type="button" class="btn btn-outline-secondary" 
                                name="btnCancelarCambiarEstado" id="btnCancelarCambiarEstado"
                                data-dismiss="modal">Cancelar</button>
                        <input type='submit' class='btn btn-outline-secondary' 
                               style="display: none;"
                               name="btnRefrescarPantalla" id="btnRefrescarPantalla" value='Aceptar'>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/BuscarInstalacion.js"></script>