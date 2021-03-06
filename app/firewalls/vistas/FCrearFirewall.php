<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div id="seccionSuperior" class="form-row mt-3 mb-3">
            <div class="col text-left">
                <h4><i class="fas fa-fire-alt"></i> CREAR FIREWALL</h4>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <form id="formCrearFirewall" name="formCrearFirewall" method="POST">
            <div class="card border-azul-clasico mt-3">
                <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
                <div class="card-body">
                    <div class="form-row">
                        <label for="nombre" class="col-sm-2 col-form-label">* Nombre:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="nombre" id="nombre" 
                                   placeholder="Nombre" required>
                        </div>
                        <label for="marca" class="col-sm-2 col-form-label">* Marca:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="marca" id="marca"
                                   placeholder="Nombre de la marca" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="modelo" class="col-sm-2 col-form-label">* Modelo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="modelo" id="modelo" maxlength="50"
                                   placeholder="Modelo" required>
                        </div>
                        <label for="nroSerie" class="col-sm-2 col-form-label">* Nro Serie:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="nroSerie" id="nroSerie" maxlength="50"
                                   placeholder="Número de serie" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="version" class="col-sm-2 col-form-label">* Versión:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="version" id="version" maxlength="50"
                                   placeholder="Versión" required>
                        </div>
                        <label for="ip" class="col-sm-2 col-form-label">* IP:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="ip" id="ip" maxlength="15"
                                   placeholder="IP" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="sucursal" class="col-sm-2 col-form-label">* Sucursal:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="sucursal" name="sucursal"></select>
                        </div>
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col"></div>
                    </div>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <button type="submit" class="btn btn-success"><i class="far fa-save"></i> GUARDAR</button>
                    <a href="FBuscarFirewall.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/CrearFirewall.js"></script>
