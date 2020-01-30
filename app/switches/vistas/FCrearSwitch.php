<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div id="seccionSuperior" class="form-row mt-3 mb-3">
            <div class="col text-left">
                <h4><i class="fas fa-ethernet"></i> CREAR SWITCH</h4>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <form id="formCrearSwitch" name="formCrearSwitch" method="POST">
            <div class="card border-azul-clasico mt-3">
                <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
                <div class="card-body">
                    <div class="form-row">
                        <label for="nombre" class="col-sm-2 col-form-label">* Nombre:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="nombre" id="nombre" maxlength="50"
                                   placeholder="Nombre" required>
                        </div>
                        <label for="modelo" class="col-sm-2 col-form-label">* Modelo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="modelo" id="modelo" maxlength="20" 
                                   placeholder="Modelo" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="version" class="col-sm-2 col-form-label">* Versión:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="version" id="version" maxlength="50"
                                   placeholder="IOS Versión" required>
                        </div>
                        <label for="instalacion" class="col-sm-2 col-form-label">* Instalación:</label>
                        <div class="col">
                            <select class="form-control mb-2" name="instalacion" id="instalacion"></select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="sitio" class="col-sm-2 col-form-label">* Ubicación:</label>
                        <div class="col">
                            <select class="form-control mb-2" name="sitio" id="sitio"></select>
                        </div>
                        <label for="rti" class="col-sm-2 col-form-label">* RTI:</label>
                        <div class="col">
                            <select class="form-control mb-2" name="rti" id="rti">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <button type="submit" class="btn btn-success"><i class="far fa-save"></i> GUARDAR</button>
                    <a href="FBuscarSwitch.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/CrearSwitch.js"></script>