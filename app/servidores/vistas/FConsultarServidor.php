<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div id="contenido">
        <div class="container-fluid">
            <div id="seccionSuperior" class="form-row mt-3">
                <div class="col text-left">
                    <h4><i class="fas fa-server"></i> BUSCAR SERVIDOR</h4>
                </div>
            </div>
            <div class="mt-3 mb-4">
                <form method="POST" name="formBuscarServidor" id="formBuscarServidor">
                    <input type="hidden" name="peticion" id="peticion">
                    <div class="card border-azul-clasico">
                        <div class="card-header text-left bg-azul-clasico text-white">Formulario de búsqueda</div>
                        <div class="card-body">
                            <div class="form-row">
                                <label for="nombre" class="col-sm-2 col-form-label text-left">Nombre:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="nombre" id="nombre" maxlength="15"
                                           title="Nombre del servidor: campo no obligatorio"
                                           placeholder="Nombre del servidor">
                                </div>
                                <label for="tipo" class="col-sm-2 col-form-label text-left">* Tipo:</label>
                                <div class="col">
                                    <select id="tipo" name="tipo" class="form-control mb-2" required>
                                        <option value="TODOS">Todos</option>
                                        <option value="Aplicaciones">Aplicaciones</option>
                                        <option value="Bases de datos">Bases de datos</option>
                                        <option value="Ambas">Ambas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <label class="col-sm-2 col-form-label">* Ambiente:</label>
                                <div class="col">
                                    <select id="ambiente" name="ambiente" class="form-control mb-2" required>
                                        <option value="TODOS">Todos</option>
                                        <option value="Produccion">Producción</option>
                                        <option value="Test">Test</option>
                                        <option value="Desarrollo">Desarrollo</option>
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col text-right">
                            <button type="submit" class="btn btn-success"  name="btnConsultarServidor">
                                <i class="fas fa-search"></i>  BUSCAR</button>
                        </div>
                    </div>
                </form>
            </div>
            <br>
            <div id="seccionInferior" class="mt-4 mb-3"></div>
        </div>
        <div class="modal fade" id="ModalCargando" tabindex="0" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false">
            <div class="modal-dialog"  style="opacity: 95%">
                <div class="modal-content bg-azul-clasico">
                    <div class="container mt-4 mb-4">
                        <div class="row">
                            <div class="col text-center" style="font-size: 1.8rem;">
                                <i class="fas fa-spinner fa-10x fa-spin text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/ConsultarServidor.js"></script>
