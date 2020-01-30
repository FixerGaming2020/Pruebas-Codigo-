<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div id="contenido">
        <div class="container-fluid">
            <div id="seccionSuperior" class="form-row mt-3">
                <div class="col text-left">
                    <h4><i class="fab fa-connectdevelop"></i> BUSCAR SERVICIO</h4>
                </div>
            </div>
            <div id="seccionCentral" class="mt-3 mb-4">
                <form id="formBuscarServicio" name="formBuscarServicio" method="POST">
                    <input type="hidden" name="peticion" id="peticion">
                    <div class="card border-azul-clasico">
                        <div class="card-header bg-azul-clasico text-white">Formulario de búsqueda</div>
                        <div class="card-body">
                            <div class="form-row">
                                <label for="nombre" class="col-2 col-form-label">Nombre:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="nombre" id="nombre" 
                                           title="Nombre del servicio: campo no obligatorio"
                                           placeholder="Nombre del servicio">
                                </div>
                                <label for="estado" class="col-2 col-form-label">* Estado:</label>
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
                            <button type="submit" class="btn btn-success" name="btnBuscarServicio">
                                <i class="fas fa-search"></i>  BUSCAR</button>
                            <a href="FCrearServicio.php" title="Ir al formulario de creación">
                                <button type="button" class="btn btn-outline-info">
                                    <i class="fas fa-plus"></i> CREAR
                                </button>
                            </a>
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
        <div class="modal fade" id="ModalCambioEstadoServicio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg border-azul-clasico">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center" id="mcesTitulo"></h4>
                    </div>
                    <div class="modal-body" id="mcesCuerpo">
                        <form id="formCambiarEstadoServicio" name="formCambiarEstadoServicio" method="POST">
                            <input type="hidden" name="mcesAccion" id="mcesAccion">
                            <input type="hidden" name="mcesIdServicio" id="mcesIdServicio">
                            <div class="form-row">
                                <b><p id="mcesNombre" name="mcesNombre"></p></b>
                                <p>&nbsp;Presione <b>GUARDAR</b> para efectuar la operación.</p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"
                                name="btnCambiarEstadoServicio" id="btnCambiarEstadoServicio">
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
        <div class="modal fade" id="ModalDatosServicio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg border-azul-clasico">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center"><i class='fas fa-info-circle'></i> INFORMACIÓN BÁSICA</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <label for="mdsSigla" class="col-sm-2 col-form-label">Nombre corto:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdsSigla" name="mdsSigla" readonly>
                            </div>
                            <label for="mdsNombre" class="col-sm-2 col-form-label">Nombre largo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdsNombre" name="mdsNombre" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdsDescripcion" class="col-sm-2 col-form-label">Descripción:</label>
                            <div class="col">
                                <textarea class="form-control mb-2" rows="5"
                                          id="mdsDescripcion" name="mdsDescripcion" readonly></textarea>
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
<script type="text/javascript" src="../js/BuscarServicio.js"></script>
