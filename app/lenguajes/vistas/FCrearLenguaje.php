<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div id="seccionSuperior" class="form-row mt-3 mb-3">
            <div class="col text-left">
                <h4><i class="fas fa-code"></i> CREAR LENGUAJE DE PROGRAMACIÓN</h4>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <form id="formCrearLenguaje" name="formCrearLenguaje" method="POST">
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
                        <label for="version" class="col-sm-2 col-form-label">* Versión:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="version" id="version" maxlength="20" 
                                   placeholder="Versión" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="descripcion" class="col-sm-2 col-form-label">* Descripción:</label>
                        <div class="col">
                            <textarea class="form-control mb-2" 
                                      name="descripcion" id="descripcion" maxlength="100"
                                      placeholder="Descripción adicional" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <button type="submit" class="btn btn-success">
                        <i class="far fa-save"></i> GUARDAR</button>
                    <a href="FBuscarLenguaje.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/CrearLenguaje.js"></script>
