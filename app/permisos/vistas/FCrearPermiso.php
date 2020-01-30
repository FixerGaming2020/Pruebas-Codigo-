<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div id="seccionSuperior" class="form-row mt-3 mb-3">
            <div class="col text-left">
                <h4><i class="fas fa-user-lock"></i> CREAR PERMISO</h4>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <form id="formCrearPermiso" name="formCrearPermiso" method="POST">
            <div class="card border-azul-clasico mt-3">
                <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
                <div class="card-body">
                    <div class="form-row">
                        <label for="titulo" class="col-sm-2 col-form-label text-left">* Titulo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" name="titulo" id="titulo" 
                                   minlength="5" maxlength="20" pattern="[A-Za-zÁÉÍÓÚÑáéíóúñ ]{5,20}"
                                   placeholder="Titulo del permiso" required>
                        </div>
                        <label for="nivel" class="col-sm-2 col-form-label text-left">* Nivel:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="nivel" name="nivel">
                                <option value="1">Menú</option>
                                <option value="2">Submenú</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="padre" class="col-sm-2 col-form-label text-left">* Padre:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="padre" name="padre" disabled></select>
                        </div>
                        <label for="link" class="col-sm-2 col-form-label text-left">* Referencia:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" name="link" id="link" 
                                   minlength="5" maxlength="100" pattern="[A-Za-z/.]{5,100}"
                                   placeholder="Referencia" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <button type="submit" class="btn btn-success"><i class="far fa-save"></i> GUARDAR</button>
                    <a href="FBuscarPermiso.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/CrearPermiso.js"></script>