<?php
require_once './header.php';

$fechaHoy = date("d/m/Y");

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $legajo = $usuario->getId();
    $nombre = $usuario->getNombre();
    $nombrePerfil = $usuario->getPerfil()->getNombre();
    $descripcionPerfil = $usuario->getPerfil()->getDescripcion();

    $controladorLog = new ControladorActividad();
    $actividadesHistoricas = $controladorLog->listarResumenHistoricoUsuario($legajo);
    $actividadesHoy = $controladorLog->listarResumenHoyUsuario($legajo);

    if (gettype($actividadesHistoricas) == "resource") {
        $filas = "";
        $total = 0;
        while ($actividad = sqlsrv_fetch_array($actividadesHistoricas, SQLSRV_FETCH_ASSOC)) {
            $total = $total + $actividad['total'];
            $filas .= '
                <tr>
                    <td>' . $actividad['aoperacion'] . '</td>
                    <td class="text-center">' . $actividad['total'] . '</td>
                </tr>';
        }
        $cuerpoCardHistorico = '
            <div class="table-responsive mt-2 mb-2">
                <table id="tbModos" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                    <thead>
                        <tr>
                            <th>Operación</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $filas . '
                        <tr>
                            <td><b>TOTAL</b></td>
                            <td class="text-center"><b>' . $total . '</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>';
    } else {
        $mensaje = $controladorLog->getMensaje();
        $cuerpoCardHistorico = ControladorHTML::getAlertaOperacion($actividadesHistoricas, $mensaje);
    }

    if (gettype($actividadesHoy) == "resource") {
        $filas = "";
        $total = 0;
        while ($actividad = sqlsrv_fetch_array($actividadesHoy, SQLSRV_FETCH_ASSOC)) {
            $total = $total + $actividad['total'];
            $filas .= '
                <tr>
                    <td>' . $actividad['aoperacion'] . '</td>
                    <td class="text-center">' . $actividad['total'] . '</td>
                </tr>';
        }
        $cuerpoCardHoy = '
            <div class="table-responsive mt-2 mb-2">
                <table id="tbModos" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                    <thead>
                        <tr>
                            <th>Operación</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $filas . '
                        <tr>
                            <td><b>TOTAL</b></td>
                            <td class="text-center"><b>' . $total . '</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>';
    } else {
        $mensaje = $controladorLog->getMensaje();
        $cuerpoCardHoy = ControladorHTML::getAlertaOperacion($actividadesHoy, $mensaje);
    }
}
?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div id="seccionSuperior" class="form-row mt-3">
            <div class="col text-left">
                <h4><i class="fas fa-home"></i> WEB CONTROL DE APLICACIONES E INVENTARIO DE ACTIVOS</h4>
            </div>
        </div>
        <div class="mt-4 mb-4">
            <div class="card border-azul-clasico">
                <div class="card-header bg-azul-clasico text-white">
                    <div class="row">
                        <div class="col">INICIO</div>
                        <div class="col text-right"><?= $fechaHoy; ?></div>
                    </div>
                </div>
                <div class="card-body bg-light">
                    <div class="card-deck mt-4 mb-4">
                        <div class="card">
                            <div class="card-header"><i class="fas fa-user"></i> <b>PERFIL DE USUARIO</b></div>
                            <div class="card-body bg-light">
                                <div class="form-row mt-2">
                                    <h6>Legajo: <?= $legajo; ?></h6>
                                </div>
                                <div class="form-row mt-2">
                                    <h6>Nombre: <?= $nombre; ?></h6>
                                </div>
                                <div class="form-row mt-2">
                                    <h6>Perfil: <?= $nombrePerfil; ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-table"></i> <b>TABLERO DE OPERACIONES</b>
                            </div>
                            <div class="card-body bg-light">
                                <div class="form-row mt-2">
                                    <button class="btn btn-outline-success btn-block" 
                                            name="btnActividad" id="btnActividad">
                                        <i class="fas fa-chart-line"></i> MI ACTIVIDAD </button>
                                </div>
                                <div class="form-row mt-2">
                                    <a href="../../principal/vistas/procesarSalir.php" class="btn-block">
                                        <button class="btn btn-outline-danger btn-block">
                                            <i class="fas fa-sign-out-alt"></i> SALIR 
                                        </button>
                                    </a>

                                </div>
                                <div class="form-row mt-2">
                                    <h6></h6>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-info-circle"></i> <b>SOBRE CAP</b>
                            </div>
                            <div class="card-body bg-light">
                                <div class="form-row mt-2">
                                    <h6>Fecha de creación: 01/02/2020</h6>
                                </div>
                                <div class="form-row mt-2">
                                    <h6>Última actualización: No posee</h6>
                                </div>
                                <div class="form-row mt-2">
                                    <h6>Versión actual: 1.0.0</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="deckActividad" class="card-deck mt-5 mb-4" style="display: none;">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-history fa-spin"></i> <b>MI ACTIVIDAD HISTORICA REGISTRADA</b>
                            </div>
                            <div class="card-body">
                                <?= $cuerpoCardHistorico; ?>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-chart-line"></i> <b>MI ACTIVIDAD DE HOY</b>
                            </div>
                            <div class="card-body">
                                <?= $cuerpoCardHoy; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-azul-clasico text-white">
                    <div class="row">
                        <div class="col text-right">
                            <p class="mb-0">Sistema Desarrollado por la Gerencia de Sistemas del Banco Santa Cruz</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#btnActividad").click(function () {
            if ($('div#deckActividad').is(":visible")) {
                $('div#deckActividad').hide();
            } else {
                $('div#deckActividad').show();
            }
        });

    });
</script>
