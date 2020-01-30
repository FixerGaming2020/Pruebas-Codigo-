
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>CAP</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Archivos de estilo -->
        <link href="../../../lib/cap/cap-admin.min.css" rel="stylesheet">
        <link href="../../../lib/cap/cap.css" rel="stylesheet">
        <!-- Archivos JavaScript -->
        <script src="../../../lib/JQuery/jquery.min.js"></script>
        <script src="../../../lib/bootstrap/bootstrap.bundle.min.js"></script>
        <script src="../../../lib/JQuery/jquery.easing.min.js"></script>
    </head>
    <script>
        $(document).ready(function () {

            var contador = 0;

            $("#iniciar").click(function () {
                contador = 1;
                cargaCuerpo(contador);
                $("#Modal").modal();
            });

            $("#avanzar").click(function () {
                if (contador < 3) {
                    contador = contador + 1;
                    cargaCuerpo(contador);
                }
            });

            $("#retroceder").click(function () {
                if (contador > 1) {
                    contador = contador - 1;
                    cargaCuerpo(contador);
                }
            });

            function cargaCuerpo(contador) {
                for (var i = 1, max = 4; i < max; i++) {
                    if (i === contador) {
                        $("#div" + i).show();
                    } else {
                        $("#div" + i).hide();
                    }
                }
            }

        });
    </script>
    <body>
        <div class="container">
            <br>
            <div class="card">
                <div class="card-header">Formulario de búsqueda</div>
                <div class="card-body">
                    <div class="form-row">
                        <label  class="col-2 col-form-label text-left">Nombre:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="nombre" id="nombre">
                        </div>
                        <label class="col-2 col-form-label text-left">* Estado:</label>
                        <div class="col">
                            <select id="estado" name="estado" class="form-control mb-2" required>
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <input type="button" class="btn btn-success" name="iniciar" id="iniciar" value="INICIAR">
        </div>
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="mcepTitulo">COMPLETA LOS DATOS</h4>
                    </div>
                    <div class="modal-body" id="cuerpo" name='cuerpo'>
                        <form id="formCambiarEstadoPerfil" name="formCambiarEstadoPerfil" method="POST">
                            <div id="div1" name="div1">
                                <p>ESTE ES EL PRIMER MODAL</p>
                                <label>Nombre: </label><input type="text">
                            </div>
                            <div id="div2" name="div2">
                                <p>ESTE ES EL SEGUNDO MODAL MODAL</p>
                                <br>
                                <label>Apellido: </label><input type="text">
                            </div>
                            <div id="div3" name="div3">
                                <p>ESTE ES EL TERCER MODAL</p>
                                <label>Sexo: </label><input type="text">
                                <input type="submit" class="btn btn-success" name="enviar" id="enviar" value="FINALIZAR">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-secondary" name="retroceder" id="retroceder" value="RETROCEDER">
                        <input type="button" class="btn btn-secondary" name="avanzar" id="avanzar" value="AVANZAR">

                    </div>
                </div>
            </div>
        </div>
    </body>
