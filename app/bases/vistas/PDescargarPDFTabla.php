<?php

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
$pdf->SetFont('times', '', 12);

if ($_GET['ref'] && $_GET['name']) {
    $idBase = $_GET['ref'];
    $nombreBase = $_GET['name'];
    $controladorTablas = new ControladorTabla();
    $tablas = $controladorTablas->listarPorBase($idBase);
    $seccion = "";
    if (gettype($tablas) == "resource") {
        // PORTADA DEL DOCUMENTO
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $fecha = date("d/m/Y H:m:s");
        $contador = 1;
        while ($tabla = sqlsrv_fetch_array($tablas, SQLSRV_FETCH_ASSOC)) {
            $nombre = utf8_encode($tabla['tnombre']);
            $fechaCreacion = date_format($tabla['tfechaCreacion'], 'd/m/Y');
            $fechaEdicion = date_format($tabla['tfechaEdicion'], 'd/m/Y H:m');
            $descripcion = utf8_encode($tabla['tdescripcion']);
            $seccion .= "<span><b>{$contador}. {$nombre}</b>
            <br>Fecha de creación: {$fechaCreacion}.
            <br>Fecha de edición: {$fechaEdicion}.
            <br>Descripción: {$descripcion}</span><br><br>";
            $contador++;
        }
        $pdf->AddPage();
        $pag3 = '
        <div style="text-align:justify;">
        <h1>ESTRUCTURA</h1>
        <br><span>En esta sección se encuentra la descripción de cada una de las tablas
        correspondientes a la base de datos <b>' . $nombreBase . '</b> a la fecha <b>' . $fecha . '</b>. Para 
        cada una de ellas se detallan la fecha de creación y la fecha de ultima modificación 
        obtenidas desde el motor de base de datos. Ademas, se proporciona una descripción 
        redactada en forma colaborativa por el personal de la Gerencia de Sistemas.</span>
        <br><br>' . $seccion . '</div>';
        $pdf->writeHTMLCell(0, 0, '', '', $pag3, 0, 1, 0, true, '', true);
    } else {
        $pdf->AddPage();
        $page = '
        <div style="text-align:justify;">
        <h1>GENERACIÓN DEL DOCUMENTO</h1>
        <br><span>No se pudo realizar la generación del PDF para la sección de tablas.</span></div>';
        $pdf->writeHTMLCell(0, 0, '', '', $page, 0, 1, 0, true, '', true);
    }
} else {
    $pdf->AddPage();
    $page = '
    <div style="text-align:justify;">
    <h1>GENERACIÓN DEL DOCUMENTO</h1>
    <br><span>No se pudo realizar la generación del PDF para la sección de tablas 
    porque no se obtuvieron los datos necesarios.</span></div>';
    $pdf->writeHTMLCell(0, 0, '', '', $page, 0, 1, 0, true, '', true);
}

$archivo = $nombreBase . "_TABLAS.pdf";
$pdf->Output($archivo, 'D');

