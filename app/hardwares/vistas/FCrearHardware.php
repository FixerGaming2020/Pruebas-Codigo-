<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div id="seccionSuperior" class="form-row mt-3 mb-3">
            <div class="col text-left">
                <h4><i class="fas fa-microchip"></i> CREAR HARDWARE</h4>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <form id="formCrearHardware" name="formCrearHardware" method="POST">
            <div class="card border-azul-clasico mt-3">
                <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
                <div class="card-body">
                    <div class="form-row">
                        <label for="tipo" class="col-sm-2 col-form-label">* Tipo:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="tipo" name="tipo">
                                <option value="Host virtual">Host virtual</option>
                                <option value="Maquina virtual">Máquina virtual</option>
                                <option value="Hardware fisico">Hardware físico</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <label for="ambiente" class="col-sm-2 col-form-label">* Ambiente:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="ambiente" name="ambiente">
                                <option value="Produccion">Producción</option>
                                <option value="DMZ">DMZ</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="sigla" class="col-sm-2 col-form-label">* Nombre corto:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="sigla" id="sigla" maxlength="20"
                                   placeholder="Sigla" required>
                        </div>
                        <label for="nombre" class="col-sm-2 col-form-label">* Nombre largo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="nombre" id="nombre" maxlength="50"
                                   placeholder="Nombre" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="sucursal" class="col-sm-2 col-form-label">* Ubicación:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="sucursal" name="sucursal"></select>
                        </div>
                        <label for="dominio" class="col-sm-2 col-form-label">* Dominio:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="dominio" name="dominio">
                                <option value="CORP">CORP</option>
                                <option value="DMZ">DMZ</option>
                                <option value="SANTACRUZ">SANTA CRUZ</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="swbase" class="col-sm-2 col-form-label">Software base:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="swbase" id="swbase" maxlength="50"
                                   placeholder="Software base">
                        </div>
                        <label for="marca" class="col-sm-2 col-form-label">Marca:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="marca" id="marca" maxlength="50"
                                   placeholder="Marca">
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="modelo" class="col-sm-2 col-form-label">Modelo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="modelo" id="modelo" maxlength="50"
                                   placeholder="Modelo">
                        </div>
                        <label for="arquitectura" class="col-sm-2 col-form-label">Arquitectura:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="arquitectura" id="arquitectura" maxlength="50"
                                   placeholder="Arquitectura">
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="core" class="col-sm-2 col-form-label">Core:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="core" id="core" maxlength="50"
                                   placeholder="Core">
                        </div>
                        <label for="procesador" class="col-sm-2 col-form-label">Procesador:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="procesador" id="procesador" maxlength="50"
                                   placeholder="Procesador">
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="mhz" class="col-sm-2 col-form-label">Mhz:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   name="mhz" id="mhz" min="1"
                                   placeholder="Mhz">
                        </div>
                        <label for="memoria" class="col-sm-2 col-form-label">Memoria (MB):</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   name="memoria" id="memoria" min="1"
                                   placeholder="Memoria">
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="disco" class="col-sm-2 col-form-label">Disco (GB):</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="disco" id="disco" maxlength="50"
                                   placeholder="Disco">
                        </div>
                        <label for="raid" class="col-sm-2 col-form-label">Raid:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="raid" id="raid" maxlength="50"
                                   placeholder="Raid">
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="disco" class="col-sm-2 col-form-label">Red:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   name="red" id="red" min="1"
                                   placeholder="Red">
                        </div>
                        <label for="rti" class="col-sm-2 col-form-label">* RTI:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="rti" name="rti">
                                <option value="Si">Sí</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="funcion" class="col-sm-2 col-form-label">* Función: </label>
                        <div class="col">
                            <textarea class="form-control mb-2" 
                                      name="funcion" id="funcion" maxlength="50" 
                                      placeholder="Función" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <button type="submit" class="btn btn-success"><i class="far fa-save"></i> GUARDAR</button>
                    <a href="FBuscarHardware.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/CrearHardware.js"></script>


