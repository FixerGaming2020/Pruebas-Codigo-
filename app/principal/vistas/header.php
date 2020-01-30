<?php
/* Incluye el archivo con las constantes del sistema y el autocargador */
require_once 'C:/xampp/htdocs/CAP/app/principal/modelos/Constantes.php';
require_once 'C:/xampp/htdocs/CAP/app/principal//modelos/AutoCargador.php';

/* Se cargan los modulos que sean necesarios */
AutoCargador::cargarModulos();
session_start();

if (isset($_SESSION['usuario'])) {
    $URL = $_SERVER["REQUEST_URI"];
    $porciones = explode("/", $URL);
    $longitud = count($porciones);
    $PAG = $porciones[$longitud - 1];
    $autorizado = FALSE;
    $usuario = $_SESSION['usuario'];
    $perfil = $usuario->getPerfil()->getNombre();
    $permisos = $usuario->getPerfil()->getPermisos();
    $menuUsuario = "";
    foreach ($permisos as $menu) {
        $menuUsuario .= '
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span>' . $menu[1] . '</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">';
        foreach ($menu[2] as $submenu) {
            if (strpos($submenu[2] . ".php", $PAG)) {
                $autorizado = TRUE;
            }
            $menuUsuario .= '<a class="dropdown-item" href="../../' . $submenu[2] . '.php"> ' . utf8_encode($submenu[1]) . '</a>';
        }
        $menuUsuario .= '
                </div>
            </li>';
    }
    if (!$autorizado && ($PAG !== "home.php")) {
        Log::escribirLineaError("Se intento acceder a una pagina que no tiene autorizada " . $PAG);
        header("Location: ../../../index.php");
    }
} else {
    header("Location: ../../../index.php");
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>CAP</title>
        <link rel="icon" href="../../../lib/img/logo_bsc_1064x1065.jpg" type="image/gif" sizes="16x16">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Archivos de estilo -->
        <link href="../../../lib/cap/cap-admin.min.css" rel="stylesheet">
        <link href="../../../lib/cap/cap.css" rel="stylesheet">
        <link href="../../../lib/dataTables/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="../../../lib/dataTables/buttons.dataTables.min.css" rel="stylesheet">
        <link href="../../../lib/fontAwesome/css/all.min.css" rel="stylesheet">
        <link href="../../../lib/select2/select2.min.css" rel="stylesheet">
        <link href="../../../lib/select2/select2.bootstrap.css" rel="stylesheet">
        <!-- Archivos JavaScript -->
        <script src="../../../lib/JQuery/jquery.min.js"></script>
        <script src="../../../lib/bootstrap/bootstrap.bundle.min.js"></script>
        <script src="../../../lib/JQuery/jquery.easing.min.js"></script>
        <script src="../../../lib/dataTables/jquery.dataTables.js"></script>
        <script src="../../../lib/dataTables/dataTables.bootstrap4.min.js"></script>
        <script src="../../../lib/dataTables/dataTables.buttons.js"></script>
        <script src="../../../lib/dataTables/jszip.min.js"></script>
        <script src="../../../lib/dataTables/pdfmake.min.js"></script>
        <script src="../../../lib/dataTables/buttons.flash.min.js"></script>
        <script src="../../../lib/dataTables/buttons.html5.min.js"></script>
        <script src="../../../lib/dataTables/buttons.print.min.js"></script>
        <script src="../../../lib/fontAwesome/js/all.min.js"></script>
        <script src="../../../lib/select2/select2.min.js"></script>
        <script src="../../../lib/cap/menuLateral.js"></script>
        <script src="../../../lib/googleCharts/loader.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand navbar-dark bg-azul-clasico static-top">
            <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
                <i class="fas fa-bars fa-lg"></i>
            </button>
            <a class="navbar-brand mr-1" href="../../principal/vistas/home.php">CAP - Banco Santa Cruz</a>
            <!-- Navbar -->
            <ul class="navbar-nav d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle fa-lg"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="../../principal/vistas/procesarSalir.php">
                            <i class="fas fa-sign-out-alt"></i> Salir</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="wrapper">
            <ul class="sidebar navbar-nav">
                <?= $menuUsuario; ?>
            </ul>
