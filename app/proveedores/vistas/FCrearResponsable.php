<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div id="seccionSuperior" class="form-row mt-3 mb-3">
            <div class="col text-left">
                <h4><i class="far fa-address-card"></i> CREAR RESPONSABLE</h4>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <form id="formCrearResponsable" name="formCrearResponsable" method="POST">
            <div class="card border-azul-clasico mt-3">
                <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
                <div class="card-body">
                    <div class="form-row">
                        <label for="proveedor" class="col-sm-2 col-form-label">* Proveedor:</label>
                        <div class="col">
                            <select class="form-control mb-2" 
                                    id="proveedor" name="proveedor"></select>
                        </div>
                        <label for="nombre" class="col-sm-2 col-form-label">* Nombre:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="nombre" id="nombre" maxlength="50"
                                   placeholder="Nombre del responsable" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="telefono" class="col-sm-2 col-form-label">Telefono:</label>
                        <div class="col">
                            <input type="tel" class="form-control mb-2" 
                                   name="telefono" id="telefono" maxlength="20"
                                   placeholder="Número de telefono">
                        </div>
                        <label for="correo" class="col-sm-2 col-form-label">* Correo:</label>
                        <div class="col">
                            <input type="email" class="form-control mb-2" 
                                   name="correo" id="correo" maxlength="50"
                                   placeholder="Correo electrónico" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <button type="submit" class="btn btn-success" name="btnCrearResponsable">
                        <i class="far fa-save"></i> GUARDAR
                    </button>
                    <a href="FBuscarResponsable.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/CrearResponsable.js"></script>