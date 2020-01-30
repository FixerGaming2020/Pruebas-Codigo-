<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div id="seccionSuperior" class="form-row mt-3 mb-3">
            <div class="col text-left">
                <h4><i class="fas fa-toolbox"></i> ENCRIPTADOR / DESENCRIPTADOR</h4>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <div class="form-row">
            <div class="col">
                <div class="card border-azul-clasico">
                    <div class="card-header bg-azul-clasico text-white">Encriptar cadena</div>
                    <div class="card-body">
                        <form name="formEncriptar" id="formEncriptar" method="POST">
                            <div class="form-row">
                                <label for="keyEncriptar" class="col-3 col-form-label text-left">Key:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="keyEncriptar" id="keyEncriptar" minlength="0"
                                           title="Key con el que se encripta la cadena" 
                                           placeholder="Key para encriptar" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="cadenaEncriptar" class="col-3 col-form-label text-left">Cadena:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="cadenaEncriptar" id="cadenaEncriptar" minlength="0"
                                           title="Cadena de texto a encriptar" 
                                           placeholder="Cadena de texto a encriptar" required>
                                </div>
                                <div class="col-2 text-right">
                                    <button type="submit" class="btn btn-success" id="btnEncriptar" name="btnEncriptar">
                                        <i class="fas fa-chevron-circle-down"></i></button>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="resultadoEncriptar" class="col-3 col-form-label text-left">Resultado:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="resultadoEncriptar" id="resultadoEncriptar"
                                           placeholder="Cadena encriptada"
                                           title="Cadena encriptada" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-azul-clasico">
                    <div class="card-header bg-azul-clasico text-white">Desencriptar cadena</div>
                    <div class="card-body">
                        <form name="formDesencriptar" id="formDesencriptar" method="POST">
                            <div class="form-row">
                                <label for="keyEncriptar" class="col-3 col-form-label text-left">Key:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="keyDesencriptar" id="keyDesencriptar" minlength="0"
                                           title="Key con el que se desencripta la cadena" 
                                           placeholder="Key para desencriptar" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="cadenaDesencriptar" class="col-3 col-form-label text-left">Cadena:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="cadenaDesencriptar" id="cadenaDesencriptar" minlength="0"
                                           title="Cadena de texto a desencriptar" 
                                           placeholder="Cadena de texto a desencriptar" required>
                                </div>
                                <div class="col-2 text-right">
                                    <button type="submit" class="btn btn-success" id="btnDesencriptar" name="btnDesencriptar">
                                        <i class="fas fa-chevron-circle-down"></i></button>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="resultadoEncriptar" class="col-3 col-form-label text-left">Resultado:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="resultadoDesencriptar" id="resultadoDesencriptar"
                                           placeholder="Cadena desencriptada"
                                           title="Cadena desencriptada" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/Encriptador.js"></script>