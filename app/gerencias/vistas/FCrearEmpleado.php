<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div id="seccionSuperior" class="form-row mt-3 mb-3">
            <div class="col text-left">
                <h4><i class="fas fa-sitemap"></i> CREAR EMPLEADO</h4>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <form id="formCrearEmpleado" name="formCrearEmpleado" method="POST">
            <div class="card border-azul-clasico">
                <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
                <div class="card-body">
                    <div class="form-row">
                        <label for="legajo" class="col-sm-2 col-form-label text-left">* Legajo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="legajo" id="legajo" maxlength="10"
                                   placeholder="Número de legajo" required>
                        </div>
                        <label for="nombre" class="col-sm-2 col-form-label text-left">* Nombre:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="nombre" id="nombre" 
                                   placeholder="Nombre completo" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="departamento" class="col-sm-2 col-form-label text-left">Departamento:</label>
                        <div class="col">
                            <select id="departamento" name="departamento" class="form-control mb-2"></select>
                        </div>
                        <label class="col-sm-2 col-form-label text-left"></label>
                        <div class="col"></div>
                    </div>
                </div>
            </div>
            <div class="form-row mt-4">
                <div class="col text-right">
                    <button type="submit" class="btn btn-success"><i class="far fa-save"></i> GUARDAR</button>
                    <a href="FBuscarEmpleado.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/CrearEmpleado.js"></script>



