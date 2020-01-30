<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div id="contenido">
        <div class="container-fluid">
            <div id="seccionSuperior" class="form-row mt-3">
                <div class="col text-left">
                    <h4><i class="far fa-building"></i> BUSCAR SITIO</h4>
                </div>
            </div>
            <div id="seccionCentral" class="mt-3 mb-4">
                <form id="formBuscarSitio" name="formBuscarSitio" method="POST">
                    <input type="hidden" name="peticion" id="peticion">
                    <div class="card border-azul-clasico">
                        <div class="card-header bg-azul-clasico text-white">Formulario de búsqueda</div>
                        <div class="card-body">
                            <div class="form-row">
                                <label for="nombre" class="col-2 col-form-label">Nombre:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="nombre" id="nombre" 
                                           title="Nombre del sitio: campo no obligatorio"
                                           placeholder="Nombre del sitio">
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
                            <button type="submit" class="btn btn-success" name="btnBuscarSitio">
                                <i class="fas fa-search"></i>  BUSCAR</button>
                            <a href="FCrearSitio.php" title="Ir al formulario de creación">
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
        <div class="modal fade" id="ModalCambioEstadoSitio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg border-azul-clasico">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center" id="mcesTitulo"></h4>
                    </div>
                    <div class="modal-body" id="mcesCuerpo">
                        <form id="formCambioEstadoSitio" name="formCambioEstadoSitio" method="POST">
                            <input type="hidden" name="mcesAccion" id="mcesAccion">
                            <input type="hidden" name="mcesIdSitio" id="mcesIdSitio">
                            <div class="form-row">
                                <b><p id="mcesNombre" name="mcesNombre"></p></b>
                                <p>&nbsp;Presione <b>GUARDAR</b> para efectuar la operación.</p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"
                                name="btnCambiarEstadoSitio" id="btnCambiarEstadoSitio">
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
        <div class="modal fade" id="ModalDatosSitio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg border-azul-clasico">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center">DATOS BÁSICOS DEL SITIO</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <label for="mdsCodigo" class="col-sm-2 col-form-label">Código:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdsCodigo" name="mdsCodigo" readonly>
                            </div>
                            <label for="mdsTipo" class="col-sm-2 col-form-label">Tipo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdsTipo" name="mdsTipo" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdsNombre" class="col-sm-2 col-form-label">Nombre:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdsNombre" name="mdsNombre" readonly>
                            </div>
                            <label for="mdsProvincia" class="col-sm-2 col-form-label">Provincia:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdsProvincia" name="mdsProvincia" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdsCiudad" class="col-sm-2 col-form-label">Ciudad:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdsCiudad" name="mdsCiudad" readonly>
                            </div>
                            <label for="mdsCodigoPostal" class="col-sm-2 col-form-label">Cod. Postal:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdsCodigoPostal" name="mdsCodigoPostal" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdsDireccion" class="col-sm-2 col-form-label">Dirección:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdsDireccion" name="mdsDireccion" readonly>
                            </div>
                            <label for="mdsOrigen" class="col-sm-2 col-form-label">Origen:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="mdsOrigen" name="mdsOrigen" readonly>
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
<script type="text/javascript" src="../js/BuscarSitio.js"></script>
