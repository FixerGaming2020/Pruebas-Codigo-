<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div id="contenido">
        <div class="container-fluid">
            <div id="seccionSuperior" class="form-row mt-3">
                <div class="col text-left">
                    <h4><i class="fas fa-database"></i> BUSCAR COLUMNA</h4>
                </div>
            </div>
            <div id="seccionCentral" class="mt-3 mb-4">
                <form method="POST" name="formBuscarCampo" id="formBuscarCampo">
                    <input type="hidden" name="peticion" id="peticion">
                    <div class="card border-azul-clasico">
                        <div class="card-header bg-azul-clasico text-white">Formulario de búsqueda</div>
                        <div class="card-body">
                            <div class="form-row">
                                <label for="base" class="col-sm-2 col-form-label">Base de datos:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="base" id="base" maxlength="20"
                                           title="Nombre de la base de datos: campo obligatorio"
                                           placeholder="Nombre de la base de datos">
                                </div>
                                <label for="tabla" class="col-sm-2 col-form-label text-left">Tabla:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="tabla" id="tabla" maxlength="20"
                                           title="Nombre de la tabla: campo obligatorio"
                                           placeholder="Nombre de la tabla">
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="nombre" class="col-sm-2 col-form-label text-left">Nombre:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="nombre" id="nombre" 
                                           minlength="1" maxlength="30" pattern="[A-Za-z0-9_]{1,30}"
                                           title="Nombre de columna: campo obligatorio"
                                           placeholder="Nombre de la columna">
                                </div>
                                <label for="descripcion" class="col-sm-2 col-form-label">Descripción:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="descripcion" id="descripcion" maxlength="20"
                                           title="Descripción: campo no obligatorio"
                                           placeholder="Descripción">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col text-right">
                            <button type="submit" class="btn btn-success" name="btnBuscarCampo">
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
        <div class="modal fade" id="ModalDatosColumna" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center"><i class='fas fa-info-circle'></i> INFORMACIÓN BÁSICA</h4>
                    </div>
                    <div class="modal-body" id="cuerpoModal">
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label">Base datos:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdcBase" name="mdcBase" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label">Tabla:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdcTabla" name="mdcTabla" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label">Nombre:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdcNombre" name="mdcNombre" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label">Nulos:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdcNulos" name="mdcNulos" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label">Tipo dato:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdcTipo" name="mdcTipo" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label text-left">Largo máximo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2"  
                                       id="mdcMaximo" name="mdcMaximo" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label text-left">Fecha proceso:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdcFechaProceso" name="mdcFechaProceso" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col"></div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label">Descripción:</label>
                            <div class="col">
                                <textarea class="form-control mb-2" rows="4"
                                          id="mdcDescripcion" name="mdcDescripcion" readonly></textarea>
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
<script type="text/javascript" src="../js/BuscarCampo.js"></script>