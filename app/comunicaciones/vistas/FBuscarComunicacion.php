<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div id="contenido">
        <div class="container-fluid">
            <div id="seccionSuperior" class="form-row mt-3">
                <div class="col text-left">
                    <h4><i class="fas fa-broadcast-tower"></i> BUSCAR COMUNICACIÓN</h4>
                </div>
            </div>
            <div class="mt-3 mb-4">
                <form method="POST" id="formBuscarComunicacion" name="formBuscarComunicacion">
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
                                           title="Nombre del elemento de comunicacion: campo no obligatorio"
                                           placeholder="Nombre del elemento">
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
                            <button type="submit" class="btn btn-success" name="btnBuscarComunicacion">
                                <i class="fas fa-search"></i>  BUSCAR</button>
                            <a href="FCrearComunicacion.php" title="Ir al formulario de creación">
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
        <div class="modal fade" id="ModalDatosComunicacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg border-azul-clasico">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center"><i class='fas fa-info-circle'></i> INFORMACIÓN BÁSICA</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <label for="mdcSigla" class="col-sm-2 col-form-label">Nombre corto:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdcSigla" id="mdcSigla" readonly>
                            </div>
                            <label for="mdcNombre" class="col-sm-2 col-form-label">Nombre largo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdcNombre" id="mdcNombre" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdcGerencia" class="col-sm-2 col-form-label">Gerencia:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdcGerencia" id="mdcGerencia" readonly>
                            </div>
                            <label for="mdcLegajo" class="col-sm-2 col-form-label">Legajo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdcLegajo" id="mdcLegajo" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdcDelegado" class="col-sm-2 col-form-label">Delegado:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdcDelegado" id="mdcDelegado" readonly>
                            </div>
                            <label for="mdcSitio" class="col-sm-2 col-form-label">Ubicación:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdcSitio" id="mdcSitio" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdcProveedor" class="col-sm-2 col-form-label">Proveedor:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdcProveedor" id="mdcProveedor" readonly>
                            </div>
                            <label for="mdcCantidad" class="col-sm-2 col-form-label">Cantidad:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdcCantidad" id="mdcCantidad" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdcRTI" class="col-sm-2 col-form-label">RTI:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdcRTI" id="mdcRTI" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col"></div>
                        </div>
                        <div class="form-row">
                            <label for="mdcDescripcion" class="col-sm-2 col-form-label">Descripción:</label>
                            <div class="col">
                                <textarea type="text" class="form-control mb-2" 
                                          name="mdcDescripcion" id="mdcDescripcion" readonly></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type='submit' class='btn btn-outline-secondary' data-dismiss="modal" value='Aceptar'>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ModalCambioEstadoComunicacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg border-azul-clasico">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center" id="mcecTitulo"></h4>
                    </div>
                    <div class="modal-body" id="mcecCuerpo">
                        <form id="formCambiarEstadoComunicacion" name="formCambiarEstadoComunicacion" method="POST">
                            <input type="hidden" name="mcecAccion" id="mcecAccion">
                            <input type="hidden" name="mcecIdComunicacion" id="mcecIdComunicacion">
                            <div class="form-row">
                                <b><p id="mcecNombre" name="mcecNombre"></p></b>
                                <p>&nbsp;Presione <b>GUARDAR</b> para efectuar la operación.</p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"
                                name="btnCambiarEstadoComunicacion" id="btnCambiarEstadoComunicacion">
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
<script type="text/javascript" src="../js/BuscarComunicacion.js"></script>