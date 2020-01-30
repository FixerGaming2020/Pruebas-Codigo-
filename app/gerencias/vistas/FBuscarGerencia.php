<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div id="contenido">
        <div class="container-fluid">
            <div id="seccionSuperior" class="form-row mt-3">
                <div class="col text-left">
                    <h4><i class="fas fa-sitemap"></i> BUSCAR GERENCIA</h4>
                </div>
            </div>
            <div id="seccionCentral" class="mt-3 mb-4">
                <form method="POST" name="formBuscarGerencia" id="formBuscarGerencia">
                    <input type="hidden" name="peticion" id="peticion">
                    <div class="card border-azul-clasico">
                        <div class="card-header bg-azul-clasico text-white">Formulario de búsqueda</div>
                        <div class="card-body">
                            <div class="form-row">
                                <label for="nombre" class="col-2 col-form-label text-left">Nombre:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="nombre" id="nombre" 
                                           title="Nombre de la gerencia: campo no obligatorio"
                                           placeholder="Nombre de la gerencia">
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
                            <button type="submit" class="btn btn-success" name="btnBuscarGerencia">
                                <i class="fas fa-search"></i>  BUSCAR</button>
                            <a href="FCrearGerencia.php" title="Ir al formulario de creación">
                                <button type="button" class="btn btn-outline-info">
                                    <i class="fas fa-plus"></i> CREAR
                                </button>
                            </a>
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
        <div class="modal fade" id="ModalCambioEstadoGerencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg border-azul-clasico">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center" id="mcegTitulo"></h4>
                    </div>
                    <div class="modal-body" id="mcegCuerpo">
                        <form id="formCambiarEstadoGerencia" name="formCambiarEstadoGerencia" method="POST">
                            <input type="hidden" name="mcegAccion" id="mcegAccion">
                            <input type="hidden" name="mcegIdGerencia" id="mcegIdGerencia">
                            <div class="form-row">
                                <b><p id="mcegNombre" name="mcegNombre"></p></b>
                                <p>&nbsp;Presione <b>GUARDAR</b> para efectuar la operación.</p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"
                                name="btnCambiarEstadoGerencia" id="btnCambiarEstadoGerencia">
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
<script type="text/javascript" src="../js/BuscarGerencia.js"></script>