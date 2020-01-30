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
$pdf->SetTitle('VISTAS');
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetFont('times', '', 12);

if ($_GET['ref'] && $_GET['name']) {
    $idBase = $_GET['ref'];
    $nombreBase = $_GET['name'];
    $controlador = new ControladorVista();
    $vistas = $controlador->listarPorBase($idBase);
    $seccion = "";
    if (gettype($vistas) == "resource") {
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $fecha = date("d/m/Y H:m:s");
        $contador = 1;
        while ($vista = sqlsrv_fetch_array($vistas, SQLSRV_FETCH_ASSOC)) {
            $nombre = utf8_encode($vista['vnombre']);
            $consulta = utf8_encode($vista['vtipoConsulta']);
            $descripcion = utf8_encode($vista['vdescripcion']);
            $seccion .= "<span><b>{$contador}. {$nombre}</b>
            <br>Tipo de consulta: {$consulta}.
            <br>Descripción: {$descripcion}</span><br><br>";
            $contador++;
        }
        $pdf->AddPage();
        $page = '
        <div style="text-align:justify;">
        <h1>VISTAS</h1>
        <br><span>En esta sección se encuentra la descripción de cada uno de las vistas
        correspondientes a la base de datos <b>' . $nombreBase . '</b> a la fecha <b>' . $fecha . '</b>. 
        Para cada una de ellos se detalla el nombre obtenido desde el motor de base de datos. 
        Ademas, se proporciona una descripción redactada en forma colaborativa por el personal de la 
        Gerencia de Sistemas.</span>
        <br><br>' . $seccion . '</div>';
        $pdf->writeHTMLCell(0, 0, '', '', $page, 0, 1, 0, true, '', true);
    } else {
        $pdf->AddPage();
        $page = '
        <div style="text-align:justify;">
        <h1>GENERACIÓN DEL DOCUMENTO</h1>
        <br><span>No se pudo realizar la generación del PDF para la sección de vistas.</span></div>';
        $pdf->writeHTMLCell(0, 0, '', '', $page, 0, 1, 0, true, '', true);
    }
} else {
    $pdf->AddPage();
    $page = '
    <div style="text-align:justify;">
    <h1>GENERACIÓN DEL DOCUMENTO</h1>
    <br><span>No se pudo realizar la generación del PDF para la sección de vistas 
    porque no se obtuvieron los datos necesarios.</span></div>';
    $pdf->writeHTMLCell(0, 0, '', '', $page, 0, 1, 0, true, '', true);
}

$archivo = $nombreBase . "_VISTAS.pdf";
$pdf->Output($archivo, 'D');
