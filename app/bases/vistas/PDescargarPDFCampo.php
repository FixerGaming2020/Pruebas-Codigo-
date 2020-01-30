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
$pdf->SetTitle('COLUMNAS DE TABLA');
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetFont('times', '', 12);

if ($_GET['ref'] && $_GET['name']) {
    $idTabla = $_GET['ref'];
    $nombreTabla = $_GET['name'];
    $controlador = new ControladorColumna();
    $columnas = $controlador->listarPorTabla($idTabla);
    $seccion = "";
    if (gettype($columnas) == "resource") {
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $fecha = date("d/m/Y H:m:s");
        $contador = 1;
        while ($columna = sqlsrv_fetch_array($columnas, SQLSRV_FETCH_ASSOC)) {
            $nombre = utf8_encode($columna['cnombre']);
            $nulos = utf8_encode($columna['cnulos']);
            $tipo = utf8_encode($columna['ctipo']);
            $maximo = utf8_encode($columna['cmaximo']);
            $descripcion = utf8_encode($columna['cdescripcion']);
            $fechaProceso = date_format($columna['cfechaProceso'], 'd/m/Y');
            $seccion .= "<span><b>{$contador}. {$nombre}</b>
            <br>Permite nulos: {$nulos}.
            <br>Tipo de dato: {$tipo}.
            <br>Tamaño máximo: {$maximo}.
            <br>Descripción: {$descripcion}</span><br><br>";
            $contador++;
        }
        $pdf->AddPage();
        $page = '
        <div style="text-align:justify;">
        <h1>COLUMNAS</h1>
        <br><span>En esta sección se encuentra la descripción de cada uno de las columnas
        correspondientes a la tabla <b>' . $nombreTabla . '</b> a la fecha <b>' . $fecha . '</b>. 
        Para cada una de ellas se detalla el nombre, si permite valores nulos, el tipo de dato
        y tamaño maximo permitido, obtenidos desde el motor de base de datos. Ademas, se 
        proporciona una descripción redactada en forma colaborativa por el personal de la 
        Gerencia de Sistemas.</span>
        <br><br>' . $seccion . '</div>';
        $pdf->writeHTMLCell(0, 0, '', '', $page, 0, 1, 0, true, '', true);
    } else {
        $pdf->AddPage();
        $page = '
        <div style="text-align:justify;">
        <h1>GENERACIÓN DEL DOCUMENTO</h1>
        <br><span>No se pudo realizar la generación del PDF para la sección de columnas.</span></div>';
        $pdf->writeHTMLCell(0, 0, '', '', $page, 0, 1, 0, true, '', true);
    }
} else {
    $pdf->AddPage();
    $page = '
    <div style="text-align:justify;">
    <h1>GENERACIÓN DEL DOCUMENTO</h1>
    <br><span>No se pudo realizar la generación del PDF para la sección de columnas
    de una tabla porque no se obtuvieron los datos necesarios.</span></div>';
    $pdf->writeHTMLCell(0, 0, '', '', $page, 0, 1, 0, true, '', true);
}

$archivo = $nombreTabla . "_COLUMNAS_TABLA.pdf";
$pdf->Output($archivo, 'D');
