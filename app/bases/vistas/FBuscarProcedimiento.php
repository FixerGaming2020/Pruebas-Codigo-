<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div id="contenido">
        <div class="container-fluid">
            <div id="seccionSuperior" class="form-row mt-3">
                <div class="col text-left">
                    <h4><i class="fas fa-database"></i> BUSCAR PROCEDIMIENTO ALMACENADO</h4>
                </div>
            </div>
            <div id="seccionCentral" class="mt-3 mb-4">
                <form method="POST" name="formBuscarProcedimiento" id="formBuscarProcedimiento">
                    <input type="hidden" name="peticion" id="peticion">
                    <div class="card border-azul-clasico">
                        <div class="card-header bg-azul-clasico text-white">Formulario de búsqueda</div>
                        <div class="card-body">
                            <div class="form-row">
                                <label for="base" class="col-sm-2 col-form-label">Base de datos:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="base" id="base" maxlength="20"
                                           title="Nombre de la base de datos: campo no obligatorio"
                                           placeholder="Nombre de la base de datos">
                                </div>
                                <label for="nombre" class="col-sm-2 col-form-label text-left">Nombre:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="nombre" id="nombre" maxlength="20"
                                           title="Nombre del procedimiento: campo no obligatorio"
                                           placeholder="Nombre del procedimiento">
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="definicion" class="col-sm-2 col-form-label text-left">Rutina:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="definicion" id="definicion" maxlength="20"
                                           title="Definicion de la rutina: campo no obligatorio"
                                           placeholder="Definición de la rutina">
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
                            <button type="submit" class="btn btn-success" name="btnBuscarProcedimiento">
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
        <div class="modal fade" id="ModalDatosProcedimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center"><i class='fas fa-info-circle'></i> INFORMACIÓN BÁSICA</h4>
                    </div>
                    <div class="modal-body" id="cuerpoModal">
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label text-left">Base de datos:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdpBase" name="mdpBase" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label text-left">Nombre:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdpNombre" name="mdpNombre" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label text-left">Creación:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdpCreacion" name="mdpCreacion" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label text-left">Edición:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2"  id="mdpEdicion" name="mdpEdicion" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label text-left">Descripción:</label>
                            <div class="col">
                                <textarea class="form-control mb-2" id="mdpDescripcion" name="mdpDescripcion" readonly></textarea>
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
<script type="text/javascript" src="../js/BuscarProcedimiento.js"></script>