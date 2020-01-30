<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div id="seccionSuperior" class="form-row mt-3">
            <div class="col text-left">
                <h4><i class="far fa-list-alt"></i> BUSCAR ACTIVIDAD USUARIOS</h4>
            </div>
        </div>
        <div id="seccionCentral" class="mt-3 mb-4">
            <form id="formBuscarActividad" name="formBuscarActividad" method="POST">
                <input type="hidden" name="peticion" id="peticion">
                <div class="card border-azul-clasico mt-3">
                    <div class="card-header bg-azul-clasico text-white">Formulario de búsqueda</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="modulo" class="col-2 col-form-label">* Modulo:</label>
                            <div class="col">
                                <select id="modulo" name="modulo" class="form-control mb-2" required>
                                    <option value="TODOS">Todos</option>
                                    <option value="APL">Aplicaciones</option>
                                    <option value="BAS">Bases de datos</option>
                                    <option value="COM">Comunicaciones</option>
                                    <option value="DEP">Dependencias</option>
                                    <option value="AUX">Elementos auxiliares</option>
                                    <option value="FIR">Firewalls</option>
                                    <option value="GER">Gerencias</option>
                                    <option value="HAR">Hardwares</option>
                                    <option value="HER">Herramientas</option>
                                    <option value="HER">Instalaciones</option>
                                    <option value="LEN">Lenguajes</option>
                                    <option value="PER">Personal</option>
                                    <option value="PLA">Plataformas</option>
                                    <option value="PRO">Proveedores</option>
                                    <option value="PSA">Procesamientos</option>
                                    <option value="SEG">Seguridad</option>
                                    <option value="SRV">Servicios</option>
                                    <option value="SER">Servidores</option>
                                    <option value="SIT">Sitios</option>
                                    <option value="SIT">Switchs</option>
                                </select>
                            </div>
                            <label for="operacion" class="col-2 col-form-label">* Operación:</label>
                            <div class="col">
                                <select id="operacion" name="operacion" class="form-control mb-2" required>
                                    <option value="TODAS">Todas</option>
                                    <option value="CREACION">Creación</option>
                                    <option value="ALTA">Alta</option>
                                    <option value="MODIFICACION">Modificación</option>
                                    <option value="BAJA">Baja</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="legajo" class="col-2 col-form-label">Legajo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="legajo" id="legajo" maxlength="10" 
                                       placeholder="Legajo de usuario">
                            </div>
                            <label for="fecha" class="col-2 col-form-label">Fecha:</label>
                            <div class="col">
                                <input type="date" class="form-control mb-2" 
                                       name="fecha" id="fecha">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="col text-right">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-search"></i> BUSCAR</button>
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
<script type="text/javascript" src="../js/BuscarActividad.js"></script>
