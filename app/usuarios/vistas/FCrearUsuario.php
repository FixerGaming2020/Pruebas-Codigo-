<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div id="seccionSuperior" class="form-row mt-3 mb-3">
            <div class="col text-left">
                <h4><i class="fas fa-user-alt"></i> CREAR USUARIO</h4>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <form id="formCrearUsuario" name="formCrearUsuario" method="POST">
            <div class="card border-azul-clasico mt-3">
                <div class="card-header text-left bg-azul-clasico text-white">Complete el formulario</div>
                <div class="card-body">
                    <div class="form-row">
                        <label for="legajo" class="col-sm-2 col-form-label">* Legajo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="legajo" id="legajo" 
                                   maxlength="10" pattern="[0-9A-Z]{4,10}"
                                   placeholder="Legajo del usuario" required>
                        </div>
                        <label for="nombre" class="col-sm-2 col-form-label">* Nombre:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="nombre" id="nombre"
                                   placeholder="Nombre del usuario" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="perfil" class="col-sm-2 col-form-label text-left">* Perfil:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="perfil" name="perfil"></select>
                        </div>
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col"></div>
                    </div>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <button type="submit" class="btn btn-success"><i class="far fa-save"></i> GUARDAR</button>
                    <a href="FBuscarUsuario.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/CrearUsuario.js"></script>