<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div id="contenido">
        <div class="container-fluid">
            <div id="seccionSuperior" class="form-row mt-3">
                <div class="col text-left">
                    <h4><i class="fas fa-server"></i> CONSULTAR JOB</h4>
                </div>
            </div>
            <div class="mt-3 mb-4">
                <form method="POST" name="formBuscarJob" id="formBuscarJob">
                    <input type="hidden" name="peticion" id="peticion">
                    <div class="card border-azul-clasico">
                        <div class="card-header text-left bg-azul-clasico text-white">Formulario de búsqueda</div>
                        <div class="card-body">
                            <div class="form-row">
                                <label for="servidor" class="col-sm-2 col-form-label">Servidor:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="servidor" id="servidor" maxlength="15"
                                           title="IP del servidor: campo no obligatorio"
                                           placeholder="IP del servidor">
                                </div>
                                <label for="nombre" class="col-sm-2 col-form-label">Nombre:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="nombre" id="nombre" maxlength="15"
                                           title="Nombre del job: campo no obligatorio"
                                           placeholder="Nombre del job">
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="descripcion" class="col-sm-2 col-form-label">Descripción:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="descripcion" id="descripcion" maxlength="20"
                                           title="Descripción: campo no obligatorio"
                                           placeholder="Descripcion">
                                </div>
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col text-right">
                            <button type="submit" class="btn btn-success"  name="btnBuscarJob">
                                <i class="fas fa-search"></i>  BUSCAR</button>
                        </div>
                    </div>
                </form>
            </div>
            <br>
            <div id="seccionInferior" class="mt-4 mb-3"></div>
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
        <div class="modal fade" id="ModalDatosJob" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg border-azul-clasico">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title"><i class='fas fa-info-circle'></i> INFORMACIÓN BÁSICA</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label">Servidor:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdsIP" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label">Nombre:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdsNombre" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label">Ambiente:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdsAmbiente" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label">Tipo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdsTipo" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label">Descripción:</label>
                            <div class="col">
                                <textarea class="form-control mb-2" rows="5"
                                          id="mdsDescripcion" readonly></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type='submit' class='btn btn-outline-secondary' 
                               data-dismiss="modal" value='Aceptar'>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/ConsultarJob.js"></script>