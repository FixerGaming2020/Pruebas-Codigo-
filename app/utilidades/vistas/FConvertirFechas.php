<?php
require_once '../../principal/vistas/header.php';
include_once '../../utilidades/modelos/FechaRelativa.php';

date_default_timezone_set('America/Argentina/Buenos_Aires');

$conversor = new FechaRelativa();

$fechaGregorianaHoy = date('Y-m-d');
$fechaRelativaHoy = $conversor->convertirARelativa($fechaGregorianaHoy);
?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div id="seccionSuperior" class="form-row mt-3 mb-3">
            <div class="col text-left">
                <h4><i class="fas fa-toolbox"></i> CONVERSOR DE FECHAS</h4>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <div class="form-row">
            <div class="col">
                <div class="card border-azul-clasico">
                    <div class="card-header bg-azul-clasico text-white">Convertir fecha gregoriana a fecha relativa</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="fecha" class="col-3 col-form-label text-left">Fecha:</label>
                            <div class="col">
                                <input type="date" class="form-control mb-2" 
                                       name="fecha" id="fecha" min="1957-01-01" value="<?= $fechaGregorianaHoy; ?>"
                                       title="Fecha a convertir en relativa" required>
                            </div>
                            <div class="col-2 text-right">
                                <button type="submit" class="btn btn-success" id="btnARelativa" name="btnARelativa">
                                    <i class="fas fa-chevron-circle-down"></i></button>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="resultadoRelativa" class="col-3 col-form-label text-left">Resultado:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="resultadoRelativa" id="resultadoRelativa" 
                                       placeholder="Fecha relativa"
                                       title="Resultado en relativa" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-azul-clasico">
                    <div class="card-header bg-azul-clasico text-white">Convertir fecha relativa a fecha gregoriana</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="nombre" class="col-3 col-form-label text-left">Fecha:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" min="1"
                                       name="numero" id="numero"  value="<?= $fechaRelativaHoy; ?>"
                                       title="Fecha a convertir en relativa" 
                                       placeholder="Fecha relativa" required>
                            </div>
                            <div class="col-2 text-right">
                                <button type="submit" class="btn btn-success" id="btnAGregoriana" name="btnAGregoriana">
                                    <i class="fas fa-chevron-circle-down"></i></button>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="estado" class="col-3 col-form-label text-left">Resultado:</label>
                            <div class="col">
                                <input type="date" class="form-control mb-2" 
                                       name="resultadoGregoriana" id="resultadoGregoriana" 
                                       title="Resultado en gregoriana" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/ConvertirFecha.js"></script>