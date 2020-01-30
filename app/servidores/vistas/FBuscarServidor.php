<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div id="contenido">
        <div class="container-fluid">
            <div id="seccionSuperior" class="form-row mt-3">
                <div class="col text-left">
                    <h4><i class="fas fa-server"></i> BUSCAR SERVIDOR</h4>
                </div>
            </div>
            <div class="mt-3 mb-4">
                <form method="POST" name="formBuscarServidor" id="formBuscarServidor">
                    <input type="hidden" name="peticion" id="peticion">
                    <div class="card border-azul-clasico">
                        <div class="card-header text-left bg-azul-clasico text-white">Formulario de búsqueda</div>
                        <div class="card-body">
                            <div class="form-row">
                                <label for="nombre" class="col-sm-2 col-form-label">Nombre:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="nombre" id="nombre" 
                                           title="Nombre del servidor: campo no obligatorio"
                                           placeholder="Nombre del servidor">
                                </div>
                                <label for="tipo" class="col-sm-2 col-form-label">* Tipo:</label>
                                <div class="col">
                                    <select id="tipo" name="tipo" class="form-control mb-2" required>
                                        <option value="Aplicaciones">Aplicaciones</option>
                                        <option value="Base de datos">Base de datos</option>
                                        <option value="Ambas">Ambas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="estado" class="col-sm-2 col-form-label">* Estado:</label>
                                <div class="col">
                                    <select id="estado" name="estado" class="form-control mb-2" required>
                                        <option value="Activo">Activo</option>
                                        <option value="Inactivo">Inactivo</option>
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col text-right">
                            <button type="submit" class="btn btn-success"  name="btnBuscarServidor">
                                <i class="fas fa-search"></i>  BUSCAR</button>
                            <a href="FCrearServidor.php" title="Ir al formulario de creación">
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
        <div class="modal fade" id="ModalCambioEstadoServidor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg border-azul-clasico">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center" id="mcesTitulo"></h4>
                    </div>
                    <div class="modal-body" id="mcesCuerpo">
                        <form id="formCambiarEstadoServidor" name="formCambiarEstadoServidor" method="POST">
                            <input type="hidden" name="mcesAccion" id="mcesAccion">
                            <input type="hidden" name="mcesIdServidor" id="mcesIdServidor">
                            <div class="form-row">
                                <b><p id="mcesNombre" name="mcesNombre"></p></b>
                                <p>&nbsp;Presione <b>GUARDAR</b> para efectuar la operación.</p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"
                                name="btnCambiarEstadoServidor" id="btnCambiarEstadoServidor">
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
        <div class="modal fade" id="ModalDatosServidor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg border-azul-clasico">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title"><i class='fas fa-info-circle'></i> INFORMACIÓN BÁSICA</h4>
                    </div>
                    <div class="modal-body" id="cuerpoModal">
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label">IP:</label>
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
<script type="text/javascript" src="../js/BuscarServidor.js"></script>