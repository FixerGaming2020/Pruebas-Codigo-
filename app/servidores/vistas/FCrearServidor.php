<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div id="seccionSuperior" class="form-row mt-3 mb-3">
            <div class="col text-left">
                <h4><i class="fas fa-server"></i> CREAR SERVIDOR</h4>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <form id="formCrearServidor" name="formCrearServidor" method="POST">
            <div class="card border-azul-clasico mt-3">
                <div class="card-header text-left bg-azul-clasico text-white">Complete el formulario</div>
                <div class="card-body">
                    <div class="form-row">
                        <label for="ip" class="col-sm-2 col-form-label text-left">* IP:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="ip" id="ip" min="7" maxlength="15"
                                   placeholder="IP del servidor" required>
                        </div>
                        <label for="nombre" class="col-sm-2 col-form-label text-left">* Nombre:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="nombre" id="nombre" min="3" maxlength="20"
                                   placeholder="Nombre del servidor" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="ambiente" class="col-sm-2 col-form-label text-left">* Ambiente:</label>
                        <div class="col">
                            <select id="ambiente" name="ambiente" class="form-control mb-2" required>
                                <option value="Produccion">Producción</option>
                                <option value="Test">Test</option>
                                <option value="Desarrollo">Desarrollo</option>
                            </select>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label text-left">* Tipo:</label>
                        <div class="col">
                            <select id="tipo" name="tipo" class="form-control mb-2" required>
                                <option value="Aplicaciones">Aplicaciones</option>
                                <option value="Base de datos">Base de datos</option>
                                <option value="Ambas">Ambas</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="descripcion" class="col-sm-2 col-form-label">* Descripción:</label>
                        <div class="col">
                            <textarea class="form-control mb-2" 
                                      name="descripcion" id="descripcion" 
                                      maxlength="500" rows="5"
                                      placeholder="Descripción del servidor" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <button type="submit" class="btn btn-success"><i class="far fa-save"></i> GUARDAR</button>
                    <a href="FBuscarServidor.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/CrearServidor.js"></script>