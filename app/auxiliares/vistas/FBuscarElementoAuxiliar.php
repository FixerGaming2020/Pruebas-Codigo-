<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div id="contenido">
        <div class="container-fluid">
            <div id="seccionSuperior" class="form-row mt-3">
                <div class="col text-left">
                    <h4><i class="fas fa-network-wired"></i> BUSCAR ELEMENTO AUXILIAR</h4>
                </div>
            </div>
            <div class="mt-3 mb-4">
                <form method="POST" id="formBuscarAuxiliar" name="formBuscarAuxiliar">
                    <input type="hidden" name="peticion" value="peticion">
                    <div class="card border-azul-clasico">
                        <div class="card-header bg-azul-clasico text-white">Formulario de búsqueda</div>
                        <div class="card-body">
                            <div class="form-row">
                                <label for="nombre" class="col-2 col-form-label text-left">Nombre:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="nombre" id="nombre" 
                                           maxlength="9" pattern="[A-Za-z0-9]{1,9}"
                                           title="Nombre del elemento auxiliar: campo no obligatorio"
                                           placeholder="Nombre del elemento">
                                </div>
                                <label for="estado" class="col-2 col-form-label text-left">* Estado:</label>
                                <div class="col">
                                    <select id="estado" name="estado" class="form-control mb-2" required>
                                        <option value="Activo">Activo</option>
                                        <option value="Inactivo">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col text-right">
                            <button type="submit" class="btn btn-success" name="btnBuscarAuxiliar">
                                <i class="fas fa-search"></i>  BUSCAR</button>
                            <a href="FCrearElementoAuxiliar.php" title="Ir al formulario de creación">
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
        <div class="modal fade" id="ModalCargando" tabindex="0" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false">
            <div class="modal-dialog"  style="opacity: 95%">
                <div class="modal-content bg-azul-clasico">
                    <div class="container mt-4 mb-4">
                        <div class="row">
                            <div class="col text-center" style="font-size: 1.8rem;">
                                <i class="fas fa-spinner fa-10x fa-spin text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ModalDatosAuxiliar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg border-azul-clasico">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center"><i class='fas fa-info-circle'></i> INFORMACIÓN BÁSICA</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <label for="mdaSigla" class="col-sm-2 col-form-label">Nombre corto:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdaSigla" id="mdaSigla" readonly>
                            </div>
                            <label for="mdaNombre" class="col-sm-2 col-form-label">Nombre largo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdaNombre" id="mdaNombre" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdaGerencia" class="col-sm-2 col-form-label">Gerencia:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdaGerencia" id="mdaGerencia" readonly>
                            </div>
                            <label for="mdaLegajo" class="col-sm-2 col-form-label">Legajo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdaLegajo" id="mdaLegajo" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdaDelegado" class="col-sm-2 col-form-label">Delegado:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdaDelegado" id="mdaDelegado" readonly>
                            </div>
                            <label for="mdaSitio" class="col-sm-2 col-form-label">Ubicación:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdaSitio" id="mdaSitio" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdaCantidad" class="col-sm-2 col-form-label">Cantidad:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdaCantidad" id="mdaCantidad" readonly>
                            </div>
                            <label for="mdaRTI" class="col-sm-2 col-form-label">RTI:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdaRTI" id="mdaRTI" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdaDescripcion" class="col-sm-2 col-form-label">Descripción:</label>
                            <div class="col">
                                <textarea type="text" class="form-control mb-2" 
                                          name="mdaDescripcion" id="mdaDescripcion" readonly></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type='submit' class='btn btn-outline-secondary' data-dismiss="modal" value='Aceptar'>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ModalCambioEstadoAuxiliar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg border-azul-clasico">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center" id="mceaTitulo"></h4>
                    </div>
                    <div class="modal-body" id="mceaCuerpo">
                        <form id="formCambiarEstadoAuxiliar" name="formCambiarEstadoAuxiliar" method="POST">
                            <input type="hidden" name="mceaAccion" id="mceaAccion">
                            <input type="hidden" name="mceaIdAuxiliar" id="mceaIdAuxiliar">
                            <div class="form-row">
                                <b><p id="mceaNombre" name="mceaNombre"></p></b>
                                <p>&nbsp;Presione <b>GUARDAR</b> para efectuar la operación.</p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"
                                name="btnCambiarEstadoAuxiliar" id="btnCambiarEstadoAuxiliar">
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
<script type="text/javascript" src="../js/BuscarElementoAuxiliar.js"></script>