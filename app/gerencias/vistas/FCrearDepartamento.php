<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div id="seccionSuperior" class="form-row mt-3 mb-3">
            <div class="col text-left">
                <h4><i class="fas fa-sitemap"></i> CREAR DEPARTAMENTO</h4>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <form id="formCrearDepartamento" name="formCrearDepartamento" method="POST">
            <div class="card border-azul-clasico">
                <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
                <div class="card-body">
                    <div class="form-row">
                        <label for="nombre" class="col-sm-2 col-form-label text-left">* Nombre:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="nombre" id="nombre" 
                                   placeholder="Nombre del departamento">
                        </div>
                        <label for="gerencia" class="col-sm-2 col-form-label text-left">* Gerencia:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="gerencia" name="gerencia"></select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row mt-2">
                <div class="col text-right">
                    <button type="submit" class="btn btn-success"><i class="far fa-save"></i> GUARDAR</button>
                    <a href="FBuscarDepartamento.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/CrearDepartamento.js"></script>