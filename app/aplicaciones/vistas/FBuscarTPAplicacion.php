<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div id="contenido">
        <div class="container-fluid">
            <div id="seccionSuperior" class="form-row mt-3">
                <div class="col text-left">
                    <h4><i class="fas fa-desktop"></i> BUSCAR APLICACIÓN</h4>
                </div>
            </div>
            <div class="mt-3 mb-4">
                <form method="POST" id="formBuscarAplicacion" name="formBuscarAplicacion">
                    <input type="hidden" name="peticion" value="peticion">
                    <div class="card border-azul-clasico">
                        <div class="card-header bg-azul-clasico text-white">Formulario de búsqueda</div>
                        <div class="card-body">
                            <div class="form-row">
                                <label for="sigla" class="col-2 col-form-label text-left">Nombre corto:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="sigla" id="sigla" 
                                           maxlength="9" pattern="[A-Za-z0-9]{1,9}"
                                           title="Nombre corto de la aplicación: campo no obligatorio"
                                           placeholder="Nombre corto">
                                </div>
                                <label for="nombre" class="col-2 col-form-label text-left">Nombre largo:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="nombre" id="nombre" 
                                           maxlength="9" pattern="[A-Za-z0-9]{1,9}"
                                           title="Nombre largo de la aplicación: campo no obligatorio"
                                           placeholder="Nombre largo">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col text-right">
                            <button type="submit" class="btn btn-success" name="btnBuscarAplicacion">
                                <i class="fas fa-search"></i> BUSCAR</button>
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
        <div class="modal fade" id="ModalDatosAplicacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg border-azul-clasico">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center"><i class='fas fa-info-circle'></i> INFORMACIÓN BÁSICA</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <label for="mdaSigla" class="col-sm-2 col-form-label">Nombre corto:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaSigla" readonly>
                            </div>
                            <label for="mdaNombre" class="col-sm-2 col-form-label">Nombre largo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaNombre" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdaTipo" class="col-sm-2 col-form-label">Tipo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaTipo" readonly>
                            </div>
                            <label for="mdaSeguridad" class="col-sm-2 col-form-label">Seguridad:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaSeguridad" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdaTecnologia" class="col-sm-2 col-form-label">Técnologia:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaTecnologia" readonly>
                            </div>
                            <label for="mdaProveedor" class="col-sm-2 col-form-label">Proveedor:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaProveedor" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdaConfidencialidad" class="col-sm-2 col-form-label">Confidencialidad:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaConfidencialidad" readonly>
                            </div>
                            <label for="mdaIntegridad" class="col-sm-2 col-form-label">Integridad:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaIntegridad" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdaDisponibilidad" class="col-sm-2 col-form-label">Disponibilidad:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaDisponibilidad" readonly>
                            </div>
                            <label for="mdaCriticidad" class="col-sm-2 col-form-label">Criticidad:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaCriticidad" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdaDescripcion" class="col-sm-2 col-form-label">Descripción:</label>
                            <div class="col">
                                <textarea type="text" class="form-control mb-2" rows="5" 
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
    </div>
</div>
<script type="text/javascript" src="../js/BuscarTPAplicacion.js"></script>

