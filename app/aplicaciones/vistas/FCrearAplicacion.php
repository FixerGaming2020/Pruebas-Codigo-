<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div id="seccionSuperior" class="form-row mt-3 mb-3">
            <div class="col text-left">
                <h4><i class="fas fa-desktop"></i> CREAR APLICACIÓN</h4>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <form id="formCrearAplicacion" name="formCrearAplicacion" method="POST">
            <div class="card border-azul-clasico mt-3">
                <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
                <div class="card-body">
                    <div class="form-row">
                        <label for="tipo" class="col-sm-2 col-form-label"
                               title="Tipo de software: campo obligatorio">* Tipo de software:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="tipo" name="tipo">
                                <option value="Aplicación">Aplicación</option>
                                <option value="Técnico">Técnico</option>
                            </select>
                        </div>
                        <label for="tecnologia" class="col-sm-2 col-form-label"
                               title="Teconologia: campo obligatorio">* Técnologia:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="tecnologia" name="tecnologia">
                                <option value="No aplica">No aplica</option>
                                <option value="Cliente-Servidor">Cliente-Servidor</option>
                                <option value="Stand Alone">Stand Alone</option>
                                <option value="Web">Web</option>
                                <option value="Web Service">Web Service</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="sigla" class="col-sm-2 col-form-label"
                               title="Nombre corto: campo obligatorio">* Nombre corto:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="sigla" id="sigla"
                                   minlength="3" maxlength="20"
                                   placeholder="Nombre corto" required>
                        </div>
                        <label for="nombre" class="col-sm-2 col-form-label"
                               title="Nombre largo: campo obligatorio">* Nombre largo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="nombre" id="nombre"
                                   minlength="3" maxlength="50"
                                   placeholder="Nombre largo" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="seguridad" class="col-sm-2 col-form-label"
                               title="Seguridad: campo obligatorio">* Seguridad:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="seguridad" name="seguridad">
                                <option value="Active Directory">Active Directory</option>
                                <option value="Integrada">Integrada</option>
                                <option value="Propia">Propia</option>
                            </select>
                        </div>
                        <label for="proveedor" class="col-sm-2 col-form-label"
                               title="Proveedor: campo no obligatorio">Proveedor:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="proveedor" name="proveedor"></select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="herramienta" class="col-sm-2 col-form-label"
                               title="Herramienta de desarrollo: campo no obligatorio">Herramienta:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="herramienta" name="herramienta"></select>
                        </div>
                        <label for="lenguaje" class="col-sm-2 col-form-label"
                               title="Lenguaje de programación: campo no obligatorio">Lenguaje:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="lenguaje" name="lenguaje"></select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="base" class="col-sm-2 col-form-label"
                               title="Base de datos: campo no obligatorio">Base de datos:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="base" name="base"></select>
                        </div>
                        <label for="plataforma" class="col-sm-2 col-form-label"
                               title="Plataforma de sistema operativo: campo obligatorio">* Plataforma SO:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="plataforma" name="plataforma" required></select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="modo" class="col-sm-2 col-form-label"
                               title="Modo de procesamiento: campo obligatorio">* Modo proc. :</label>
                        <div class="col">
                            <select class="form-control mb-2" id="modo" name="modo" required></select>
                        </div>
                        <label for="lugar" class="col-sm-2 col-form-label"
                               title="Lugar de procesamiento: campo obligatorio">* Lugar proc. :</label>
                        <div class="col">
                            <select class="form-control mb-2" id="lugar" name="lugar"></select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="sdesarrollo" class="col-sm-2 col-form-label"
                               title="Servidor en desarrollo: campo no obligatorio">Servidor desarrollo:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="sdesarrollo" name="sdesarrollo"></select>
                        </div>
                        <label for="pdesarrollo" class="col-sm-2 col-form-label"
                               title="Puerto en desarrollo: campo no obligatorio">Puerto desarrollo:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   name="pdesarrollo" id="pdesarrollo" min="1"
                                   placeholder="Puerto de desarrollo">
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="delegado" class="col-sm-2 col-form-label"
                               title="Delegado: campo no obligatorio">Delegado:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="delegado" name="delegado"></select>
                        </div>
                        <label for="rti" class="col-sm-2 col-form-label"
                               title="Riesgo de TI: campo obligatorio">* RTI:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="rti" name="rti">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="descripcion" class="col-sm-2 col-form-label"
                               title="Descripción: campo obligatorio">* Descripción:</label>
                        <div class="col">
                            <textarea class="form-control mb-2" 
                                      name="descripcion" id="descripcion"
                                      rows="5" minlength="10" maxlength="500"
                                      placeholder="Descripción de la aplicación" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <button type="submit" class="btn btn-success"><i class="far fa-save"></i> GUARDAR</button>
                    <a href="FBuscarPPAplicacion.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/CrearAplicacion.js"></script>