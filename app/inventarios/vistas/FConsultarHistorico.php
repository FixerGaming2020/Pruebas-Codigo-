<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div id="seccionSuperior" class="form-row mt-3">
            <div class="col text-left">
                <h4><i class="fas fa-clipboard-list"></i> CONSULTAR HISTORICO</h4>
            </div>
        </div>
        <div class="mt-3 mb-4">
            <form method="POST" id="formConsultarHistorico" name="formConsultarHistorico">
                <input type="hidden" name="peticion" id="peticion">
                <div class="card border-azul-clasico">
                    <div class="card-header bg-azul-clasico text-white">Formulario de búsqueda</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="elemento" class="col-2 col-form-label text-left">* Elemento:</label>
                            <div class="col">
                                <select id="elemento" name="elemento" class="form-control mb-2" required>
                                    <option value="PHistoricoAplicacion">Aplicación</option>
                                    <option value="PHistoricoBase">Base de datos</option>
                                    <option value="PHistoricoComunicacion">Comunicación</option>
                                    <option value="PHistoricoAuxiliares">Elementos auxiliares</option>
                                    <option value="PHistoricoFirewall">Firewall</option>
                                    <option value="PHistoricoHardware">Hardware</option>
                                    <option value="PHistoricoInstalacion">Instalación</option>
                                    <option value="PHistoricoPersonal">Personal</option>
                                    <option value="PHistoricoSwitch">Switch</option>
                                </select>
                            </div>
                            <label for="estado" class="col-2 col-form-label text-left">* Inventario:</label>
                            <div class="col">
                                <select class="form-control mb-2" id="inventario" name="inventario" 
                                        title="Nombre del inventario en formato AAAAMM" required></select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="col text-right">
                        <button type="submit" class="btn btn-success" name="btnConsultarInventario">
                            <i class="fas fa-search"></i>  BUSCAR</button>
                    </div>
                </div>
            </form>
        </div>
        <div id="seccionInferior"></div>
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
<script type="text/javascript" src="../js/ConsultarInventario.js"></script>