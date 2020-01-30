<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div id="contenido">
        <div class="container-fluid">
            <div id="seccionSuperior" class="form-row mt-3">
                <div class="col text-left">
                    <h4><i class="far fa-address-card"></i> CONSULTAR PROVEEDOR</h4>
                </div>
            </div>
            <div id="seccionCentral" class="mt-3 mb-4">
                <form method="POST" name="formBuscarProveedor" id="formBuscarProveedor">
                    <input type="hidden" name="peticion" id="peticion">
                    <div class="card mt-2 mb-2 border-azul-clasico">
                        <div class="card-header text-left bg-azul-clasico text-white">Formulario de búsqueda</div>
                        <div class="card-body">
                            <div class="form-row">
                                <label for="nombre" class="col-2 col-form-label text-left">Nombre:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="nombre" id="nombre" maxlength="10"
                                           title="Nombre del proveedor: campo no obligatorio"
                                           placeholder="Nombre del proveedor">
                                </div>
                                <label for="provincia" class="col-2 col-form-label text-left">Provincia:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="provincia" id="provincia" maxlength="10"
                                           title="Nombre de la provincia: campo no obligatorio"
                                           placeholder="Nombre de la provincia">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col text-right">
                            <button type="submit" class="btn btn-success" name="btnBuscarProveedor">
                                <i class="fas fa-search"></i>  BUSCAR
                            </button>
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
<script type="text/javascript" src="../js/ConsultarProveedor.js"></script>