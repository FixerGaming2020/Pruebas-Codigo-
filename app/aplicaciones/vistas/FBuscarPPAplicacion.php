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
                                <label for="nombre" class="col-2 col-form-label text-left">Nombre:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="nombre" id="nombre" 
                                           maxlength="9" pattern="[A-Za-z0-9]{1,9}"
                                           title="Nombre de la aplicación: campo no obligatorio"
                                           placeholder="Nombre">
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
                            <button type="submit" class="btn btn-success" name="btnBuscarAplicacion">
                                <i class="fas fa-search"></i>  BUSCAR</button>
                            <a href="FCrearAplicacion.php" title="Ir al formulario de creación">
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
                            <label for="mdaNombreHerramienta" class="col-sm-2 col-form-label">Herramienta:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2"  id="mdaNombreHerramienta" readonly>
                            </div>
                            <label for="mdaVersionHerramienta" class="col-sm-2 col-form-label">Versión:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2"  id="mdaVersionHerramienta" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdaNombreLenguaje" class="col-sm-2 col-form-label">Lenguaje:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaNombreLenguaje" readonly>
                            </div>
                            <label for="mdaVersionLenguaje" class="col-sm-2 col-form-label">Versión:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaVersionLenguaje" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdaBaseDatos" class="col-sm-2 col-form-label">Base datos:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaBaseDatos" readonly>
                            </div>
                            <label for="mdaModo" class="col-sm-2 col-form-label">Modo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaModo" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdaLugar" class="col-sm-2 col-form-label">Lugar:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaLugar" readonly>
                            </div>
                            <label for="mdaGerencia" class="col-sm-2 col-form-label">Gerencia:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaGerencia" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdaDelegado" class="col-sm-2 col-form-label">Delegado:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaDelegado" readonly>
                            </div>
                            <label for="mdaRTI" class="col-sm-2 col-form-label">RTI:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaRTI" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdaServidorProduccion" class="col-sm-2 col-form-label">Ser. Producción:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaServidorProduccion" readonly>
                            </div>
                            <label for="mdaPuertoProduccion" class="col-sm-2 col-form-label">Puerto:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaPuertoProduccion" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdaServidorTest" class="col-sm-2 col-form-label">Ser. Test:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaServidorTest" readonly>
                            </div>
                            <label for="mdaPuertoTest" class="col-sm-2 col-form-label">Puerto:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaPuertoTest" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdaServidorDesarrollo" class="col-sm-2 col-form-label">Ser. Desarrollo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaServidorDesarrollo" readonly>
                            </div>
                            <label for="mdaPuertoDesarrollo" class="col-sm-2 col-form-label">Puerto:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" id="mdaPuertoDesarrollo" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdaDescripcion" class="col-sm-2 col-form-label">Descripción:</label>
                            <div class="col">
                                <textarea type="text" class="form-control mb-2"  rows="5" 
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
        <div class="modal fade" id="ModalCambioEstadoAplicacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg border-azul-clasico">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center" id="mceaTitulo"></h4>
                    </div>
                    <div class="modal-body" id="mceaCuerpo">
                        <form id="formCambiarEstadoAplicacion" name="formCambiarEstadoAplicacion" method="POST">
                            <input type="hidden" name="mceaAccion" id="mceaAccion">
                            <input type="hidden" name="mceaIdAplicacion" id="mceaIdAplicacion">
                            <div class="form-row">
                                <b><p id="mceaNombre" name="mceaNombre"></p></b>
                                <p>&nbsp;Presione <b>GUARDAR</b> para efectuar la operación.</p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"
                                name="btnCambiarEstadoAplicacion" id="btnCambiarEstadoAplicacion">
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
<script type="text/javascript" src="../js/BuscarPPAplicacion.js"></script>