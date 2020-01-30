<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div id="contenido">
        <div class="container-fluid">
            <div id="seccionSuperior" class="form-row mt-3">
                <div class="col text-left">
                    <h4><i class="fas fa-microchip"></i> BUSCAR HARDWARE</h4>
                </div>
            </div>
            <div class="mt-3 mb-4">
                <form method="POST" id="formBuscarHardware" name="formBuscarHardware">
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
                                           title="Nombre del hardware: campo no obligatorio"
                                           placeholder="Nombre del hardware">
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
                            <button type="submit" class="btn btn-success" name="btnBuscarHardware">
                                <i class="fas fa-search"></i>  BUSCAR</button>
                            <a href="FCrearHardware.php" title="Ir al formulario de creación">
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
        <div class="modal fade" id="ModalCambioEstadoHardware" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg border-azul-clasico">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center" id="mcehTitulo"></h4>
                    </div>
                    <div class="modal-body" id="mcehCuerpo">
                        <form id="formCambiarEstadoHardware" name="formCambiarEstadoHardware" method="POST">
                            <input type="hidden" name="mcehAccion" id="mcehAccion">
                            <input type="hidden" name="mcehIdHardware" id="mcehIdHardware">
                            <div class="form-row">
                                <b><p id="mcehNombre" name="mcehNombre"></p></b>
                                <p>&nbsp;Presione <b>GUARDAR</b> para efectuar la operación.</p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"
                                name="btnCambiarEstadoHardware" id="btnCambiarEstadoHardware">
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
        <div class="modal fade" id="ModalDatosHardware" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg border-azul-clasico">
                <div class="modal-content">
                    <div class="modal-header bg-azul-clasico text-white">
                        <h4 class="modal-title text-center"><i class='fas fa-info-circle'></i> INFORMACIÓN BÁSICA</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <label for="mdhTipo" class="col-sm-2 col-form-label">Tipo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdhTipo" id="mdhTipo" readonly>
                            </div>
                            <label for="mdhSigla" class="col-sm-2 col-form-label">Nombre corto:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdhSigla" id="mdhSigla" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdhNombre" class="col-sm-2 col-form-label">Nombre largo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdhNombre" id="mdhNombre" readonly>
                            </div>
                            <label for="mdhDominio" class="col-sm-2 col-form-label">Dominio:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdhDominio" id="mdhDominio" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdhAmbiente" class="col-sm-2 col-form-label">Ambiente:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdhAmbiente" id="mdhAmbiente" readonly>
                            </div>
                            <label for="mdhSwBase" class="col-sm-2 col-form-label">Software base:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdhSwBase" id="mdhSwBase" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdhUbicacion" class="col-sm-2 col-form-label">Ubicación:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdhUbicacion" id="mdhUbicacion" readonly>
                            </div>
                            <label for="mdhMarca" class="col-sm-2 col-form-label">Marca:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdhMarca" id="mdhMarca" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdhModelo" class="col-sm-2 col-form-label">Modelo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdhModelo" id="mdhModelo" readonly>
                            </div>
                            <label for="mdhArquitectura" class="col-sm-2 col-form-label">Arquitectura:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdhArquitectura" id="mdhArquitectura" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdhCore" class="col-sm-2 col-form-label">Core:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdhCore" id="mdhCore" readonly>
                            </div>
                            <label for="mdhProcesador" class="col-sm-2 col-form-label">Procesador:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdhProcesador" id="mdhProcesador" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdhMhz" class="col-sm-2 col-form-label">Mhz:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdhMhz" id="mdhMhz" readonly>
                            </div>
                            <label for="mdhMemoria" class="col-sm-2 col-form-label">Memoria:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdhMemoria" id="mdhMemoria" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdhDisco" class="col-sm-2 col-form-label">Disco:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdhDisco" id="mdhDisco" readonly>
                            </div>
                            <label for="mdhRaid" class="col-sm-2 col-form-label">Raid:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdhRaid" id="mdhRaid" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdhRed" class="col-sm-2 col-form-label">Red:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdhRed" id="mdhRed" readonly>
                            </div>
                            <label for="mdhRTI" class="col-sm-2 col-form-label">RTI:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdhRTI" id="mdhRTI" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdhFuncion" class="col-sm-2 col-form-label">Función:</label>
                            <div class="col">
                                <textarea type="text" class="form-control mb-2" 
                                          name="mdhFuncion" id="mdhFuncion" readonly></textarea>
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
<script type="text/javascript" src="../js/BuscarHardware.js"></script>