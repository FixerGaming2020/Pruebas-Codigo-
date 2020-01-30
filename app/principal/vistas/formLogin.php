<?php
if (isset($_SESSION['mensajeLogin'])) {
    echo "MENSAJE " . $_SESSION['mensajeLogin'];
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title>CAP</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="./lib/cap/cap-admin.min.css">
        <link rel="stylesheet" href="./lib/cap/cap.css">
    </head> 
    <body class="bg-dark">
        <div class="container">
            <div class="card card-login mx-auto mt-5">
                <div class="card-header">Formulario de ingreso</div>
                <div class="card-body">
                    <form method="POST" action="principal_home">
                        <div class="form-group">
                            <div class="form-label-group">
                                <input type="text" class="form-control" 
                                       name="legajo" id="legajo" 
                                       required>
                                <label for="legajo">Legajo</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <input type="password" class="form-control" 
                                       name="clave" id="clave"
                                       placeholder="Clave personal" required>
                                <label for="clave">Clave</label>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-outline-success btn-block" value="INGRESAR">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>