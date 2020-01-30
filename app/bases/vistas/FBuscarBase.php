<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div id="contenido">
        <div class="container-fluid">
            <div id="seccionSuperior" class="form-row mt-3">
                <div class="col text-left">
                    <h4><i class="fas fa-database"></i> BUSCAR BASE DE DATOS</h4>
                </div>
            </div>
            <div id="seccionCentral" class="mt-3 mb-4">
                <form method="POST" name="formBuscarBase" id="formBuscarBase">
                    <input type="hidden" name="peticion" id="peticion">
                    <div class="card border-azul-clasico">
                        <div class="card-header bg-azul-clasico text-white">Formulario de búsqueda</div>
                        <div class="card-body">
                            <div class="form-row">
                                <label for="nombre" class="col-sm-2 col-form-label">Nombre:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="nombre" id="nombre" maxlength="20"
                                           title="Nombre de la base de datos: campo no obligatorio"
                                           placeholder="Nombre de la base de datos">
                                </div>
                                <label for="motor" class="col-sm-2 col-form-label">Motor:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="motor" id="motor" maxlength="20"
                                           title="Nombre del motor: campo no obligatorio"
                                           placeholder="Nombre del motor">
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="collation" class="col-sm-2 col-form-label">Collation:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="collation" id="collation" maxlength="20"
                                           title="Collation: campo no obligatorio"
                                           placeholder="Collation">
                                </div>
                                <label class="col-sm-2 col-form-label text-left"></label>
                                <div class="col"></div>
                            </div>    
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col text-right">
                            <button type="submit" class="btn btn-success" name="btnBuscarBase">
                                <i class="fas fa-search"></i>  BUSCAR
                            </button>
                        </div>
                    </div>
                </form>
            </div>
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
        <div class="modal fade" id="ModalDatosBase" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center"><i class='fas fa-info-circle'></i> INFORMACIÓN BÁSICA</h4>
                    </div>
                    <div class="modal-body" id="cuerpoModal">
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label text-left">Nombre:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdbNombre" name="mdbNombre" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label text-left">Creación:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdbCreacion" name="mdbCreacion" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label text-left">Motor:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdbMotor" name="mdbMotor" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label text-left">Collation:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdbCollation" name="mdbCollation" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label text-left">IP Prod:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdbIPProduccion" name="mdbIPProduccion" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label text-left">Nombre Prod:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2"  
                                       id="mdbNombreProduccion" name="mdbNombreProduccion" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label text-left">IP Test:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdbIPTest" name="mdbIPTest" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label text-left">Nombre Test:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2"  
                                       id="mdbNombreTest" name="mdbNombreTest" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label text-left">IP Desa:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdbIPDesarrollo" name="mdbIPDesarrollo" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label text-left">Nombre Desa:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2"  
                                       id="mdbNombreDesarrollo" name="mdbNombreDesarrollo" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label text-left">Estado:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdbEstado" name="mdbEstado" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label text-left">RTI:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2"  id="mdbRTI" name="mdbRTI" readonly>
                            </div>

                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label text-left">Fecha proceso:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdbFechaProceso" name="mdbFechaProceso" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col"></div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label">Total tablas:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdbTablas" name="mdbTablas" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col"></div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label">Total vistas:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2"  
                                       id="mdbVistas" name="mdbVistas" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col"></div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label">Total SP:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdbSPS" name="mdbSPS" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col"></div>
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
<script type="text/javascript" src="../js/BuscarBase.js"></script>