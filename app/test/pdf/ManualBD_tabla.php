<?php

//agrega libreria tcpdf
require_once '../../../lib/tcpdf-6.3.1/tcpdf.php';
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetMargins(20, 25, 20);
$pdf->SetHeaderMargin(55);
$pdf->setPrintHeader(false);
$pdf->SetCreator('Banco Santa Cruz');
$pdf->SetAuthor('Banco Santa Cruz');
$pdf->SetTitle('CONSTANCIA DE SALDO');
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetFont('times', '', 14);

$controladorTablas = new ControladorTabla();

$tablas = $controladorTablas->listarPorBase("25013300006");

// PORTADA DEL DOCUMENTO

date_default_timezone_set("America/Argentina/Buenos_Aires");
$fecha = date("d-m-Y H:m:s");
$pdf->AddPage();
$pag1 = '
<div style="text-align:center;">
    <img src="../../../lib/img/logo_bsc_1064x1065.jpg" 
         style="height:150 px; width:150 px; text-align:center;">
</div>
<br>
<span style="font-size: 1.3em; font-weight:bold; text-align:center;">ESTRUCTURA DE TABLAS</span>
<br><br>
<span style="font-size:0.9em;">Documento generado el día ' . $fecha . '</span><br/>';
$pdf->writeHTMLCell(0, 0, '', '', $pag1, 0, 1, 0, true, '', true);

// ESTRUCTURA DE TABLAS

$filas = "";
if (gettype($tablas) == "resource") {
    $pdf->SetFont('times', '', 12);
    $contador = 0;
    $secciones = array();
    while ($tabla = sqlsrv_fetch_array($tablas, SQLSRV_FETCH_ASSOC)) {
        $fechaCreacion = date_format($tabla['fechaCreacion'], 'd/m/Y');
        $fechaModificacion = date_format($tabla['fechaModificacion'], 'd/m/Y H:m');
        $filas .= '
            <tr>
                <td nobr="true" width="280">' . $tabla['nombreTabla'] . '</td>
                <td nobr="true" align="center" width="80">' . $fechaCreacion . '</td>
                <td nobr="true" align="center" width="100">' . $fechaModificacion . '</td>
            </tr>';
        $contador++;
        if ($contador >= 35) {
            $contador = 0;
            $secciones[] = $filas;
            $filas = "";
        }
    }
    if ($contador > 0) {
        $secciones[] = $filas;
    }

    foreach ($secciones as $seccion) {
        $pdf->AddPage();
        $pag3 = '
        <div>
            <span style="font-size: 1em; font-weight:bold;">ESTRUCTURA</span><br><br>
            <table cellspacing="0" cellpadding="1" border="1" nobr="true">
                <thead>
                    <tr nobr="true">
                        <td nobr="true" align="center" width="280">Nombre</td>
                        <td nobr="true" align="center" width="80">Fecha creación</td>
                        <td nobr="true" align="center" width="100">Fecha edición</td>
                    </tr>
                </thead>
                <tbody>' . $seccion . '</tbody>
            </table>
        </div>';
        $pdf->writeHTML($pag3, true, false, false, false, '');
    }
}



$archivo = DOCS_BASE . "\\ejemplo.pdf";
$pdf->Output($archivo, 'F');