<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div id="contenido">
        <div class="container-fluid">
            <div id="seccionSuperior" class="form-row mt-3">
                <div class="col text-left">
                    <h4><i class="fas fa-laptop-code"></i> CONSULTAR HERRAMIENTA DE DESARROLLO</h4>
                </div>
            </div>
            <div class="mt-3 mb-4">
                <form method="POST" id="formBuscarHerramienta" name="formBuscarHerramienta">
                    <input type="hidden" name="peticion" id="peticion">
                    <div class="card border-azul-clasico">
                        <div class="card-header bg-azul-clasico text-white">Formulario de búsqueda</div>
                        <div class="card-body">
                            <div class="form-row">
                                <label for="nombre" class="col-2 col-form-label">Nombre:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="nombre" id="nombre" maxlength="10"
                                           title="Nombre de la herramienta: campo no obligatorio"
                                           placeholder="Nombre de la herramienta">
                                </div>
                                <label for="version" class="col-2 col-form-label">Versión:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="version" id="version" maxlength="10"
                                           title="Versión de la herramienta: campo no obligatorio"
                                           placeholder="Versión de la herramienta">
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="fabricante" class="col-2 col-form-label">Fabricante:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="fabricante" id="fabricante" maxlength="10"
                                           title="Nombre del fabricante: campo no obligatorio"
                                           placeholder="Nombre del fabricante">
                                </div>
                                <label class="col-2 col-form-label"></label>
                                <div class="col"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col text-right">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-search"></i>  BUSCAR</button>
                        </div>
                    </div>
                </form>
            </div>
            <br>
            <div id="seccionInferior" class="mt-4 mb-2"></div>
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
<script type="text/javascript" src="../js/ConsultarHerramientaDesarrollo.js"></script>

