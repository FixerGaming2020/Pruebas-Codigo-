<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div id="contenido">
        <div class="container-fluid">
            <div id="seccionSuperior" class="form-row mt-3">
                <div class="col text-left">
                    <h4><i class="fas fa-fire-alt"></i> BUSCAR FIREWALL</h4>
                </div>
            </div>
            <div class="mt-3 mb-4">
                <form method="POST" id="formBuscarFirewall" name="formBuscarFirewall">
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
                                           title="Nombre del firewall: campo no obligatorio"
                                           placeholder="Nombre del firewall">
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
                            <button type="submit" class="btn btn-success" name="btnBuscarFirewall">
                                <i class="fas fa-search"></i>  BUSCAR</button>
                            <a href="FCrearFirewall.php" title="Ir al formulario de creación">
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
        <div class="modal fade" id="ModalDatosFirewall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg  border-azul-clasico">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center"><i class='fas fa-info-circle'></i> INFORMACIÓN BÁSICA</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label">Nombre:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdfNombre" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label">Marca:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdfMarca" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label">Modelo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdfModelo" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label">Nro Serie:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdfNroSerie" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label">Versión:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdfVersion" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label">IP:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdfIp" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label">Sucursal:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdfSucursal" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type='submit' class='btn btn-outline-secondary' 
                               data-dismiss="modal" value='Aceptar'>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ModalCambioEstadoFirewall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg border-azul-clasico">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center" id="mcefTitulo"></h4>
                    </div>
                    <div class="modal-body" id="mcefCuerpo">
                        <form id="formCambiarEstadoFirewall" name="formCambiarEstadoFirewall" method="POST">
                            <input type="hidden" name="mcefAccion" id="mcefAccion">
                            <input type="hidden" name="mcefIdFirewall" id="mcefIdFirewall">
                            <div class="form-row">
                                <b><p id="mcefNombre" name="mcefNombre"></p></b>
                                <p>&nbsp;Presione <b>GUARDAR</b> para efectuar la operación.</p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"
                                name="btnCambiarEstadoFirewall" id="btnCambiarEstadoFirewall">
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
<script type="text/javascript" src="../js/BuscarFirewall.js"></script>