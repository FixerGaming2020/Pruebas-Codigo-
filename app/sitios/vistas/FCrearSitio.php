<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div id="seccionSuperior" class="form-row mt-3">
            <div class="col text-left">
                <h4><i class="far fa-building"></i> CREAR SITIO</h4>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <form id="formCrearSitio" name="formCrearSitio" method="POST">
            <div class="card border-azul-clasico mt-3">
                <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
                <div class="card-body">
                    <div class="form-row">
                        <label for="codigo" class="col-sm-2 col-form-label">* Código:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="codigo" id="codigo" maxlength="5"
                                   placeholder="Código del sitio">
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">* Tipo:</label>
                        <div class="col">
                            <select class="form-control mb-2" name="tipo" id="tipo">
                                <option value="CPD">Centro de procesamiento de datos</option>
                                <option value="SAR">Sitio de almacenamiento de resguardos</option>
                                <option value="SUC">Sucursal</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="nombre" class="col-sm-2 col-form-label">* Nombre:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="nombre" id="nombre" maxlength="50"
                                   placeholder="Nombre del sitio">
                        </div>
                        <label class="col-sm-2 col-form-label">* Provincia</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="provincia" id="provincia" maxlength="50"
                                   placeholder="Nombre de la provincia">
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="localidad" class="col-sm-2 col-form-label">* Localidad:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="localidad" id="localidad" maxlength="50"
                                   placeholder="Nombre de la localidad">
                        </div>
                        <label class="col-sm-2 col-form-label">* Código postal:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   name="codigoPostal" id="codigoPostal" maxlength="50"
                                   placeholder="Código postal">
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="direccion" class="col-sm-2 col-form-label">* Dirección:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="direccion" id="direccion" maxlength="50"
                                   placeholder="Dirección">
                        </div>
                        <label class="col-sm-2 col-form-label">* Origen:</label>
                        <div class="col">
                            <select class="form-control mb-2" name="origen" id="origen">
                                <option value="Propio">Propio</option>
                                <option value="Tercerizado">Tercerizado</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <button type="submit" class="btn btn-success"><i class="far fa-save"></i> GUARDAR</button>
                    <a href="FBuscarSitio.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/CrearSitio.js"></script>