<?php

//agrega libreria tcpdf
require_once '../../../lib/tcpdf-6.3.1/tcpdf.php';
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->setPrintHeader(false);
$pdf->SetCreator('BANCO SANTA CRUZ');
$pdf->SetAuthor('BANCO SANTA CRUZ');
$pdf->SetTitle('ESTRUCTURA DE TABLAS');
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetFont('times', '', 14);

$controladorTablas = new ControladorTabla();
$tablas = $controladorTablas->listarPorBase("25025100015");
$seccion = "";
if (gettype($tablas) == "resource") {
    // PORTADA DEL DOCUMENTO
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $fecha = date("d/m/Y H:m:s");
    $pdf->SetFont('times', '', 12);
    $contador = 1;
    while ($tabla = sqlsrv_fetch_array($tablas, SQLSRV_FETCH_ASSOC)) {
        $nombre = utf8_encode($tabla['nombreTabla']);
        $fechaCreacion = date_format($tabla['fechaCreacion'], 'd/m/Y');
        $fechaEdicion = date_format($tabla['fechaModificacion'], 'd/m/Y H:m');
        $descripcion = utf8_encode($tabla['descripcion']);
        $seccion .= "<span><b>{$contador}. {$nombre}</b>
        <br>Fecha de creación: {$fechaCreacion}.
        <br>Fecha de modificación: {$fechaEdicion}.
        <br>Descripción: {$descripcion} texto agregado de forma manual para probar el largo. Seguimos agregando cosas pero el margen derecho se ve mal</span><br><br>";
        $contador++;
    }
    $pdf->AddPage();
    $pag3 = '
    <div style="text-align:justify;">
    <h1>ESTRUCTURA</h1>
    <br><span>En esta sección se encuentra la descripción de cada una de las tablas
    correspondientes a la base de datos <b>BASE</b> a la fecha <b>' . $fecha . '</b>. Para 
    cada una de ellas se detallan la fecha de creación y la fecha de ultima modificación 
    obtenidas desde el motor de base de datos. Ademas, se proporciona una descripción 
    redactada en forma colaborativa por el personal de la Gerencia de Sistemas.</span>
    <br><br>' . $seccion . '</div>';
    $pdf->writeHTMLCell(0, 0, '', '', $pag3, 0, 1, 0, true, '', true);
}

$archivo = DOCS_BASE . "\\BASE_TABLAS.pdf";
$pdf->Output($archivo, 'F');
