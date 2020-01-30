<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../../utilidades/modelos/FechaRelativa.php';

date_default_timezone_set('America/Argentina/Buenos_Aires');

$date1 = new DateTime("1900-01-01");
$date2 = new DateTime("2019-12-11");
$diff = $date1->diff($date2);

echo "<br>" . $diff->days . ' days ';

$date3 = new DateTime("1900-01-01");
$date4 = new DateTime("1957-01-01");
$diff2 = $date3->diff($date4);
echo "<br>" . $diff2->days . ' days ';

$relativa = ($diff->days - $diff2->days);
echo "<br>RELATIVA: " . $relativa;


$fecha = new DateTime('1900-01-01');
$fecha->add(new DateInterval('P' . ($diff2->days + $relativa + 1) . 'D'));
echo "<br>" . $fecha->format('d/m/Y') . "\n";



$frelativa = new FechaRelativa();

echo "<br> Clase: " . $frelativa->convertirARelativa("2019-12-11");

echo "<br>".$frelativa->convertirAFecha(22986);

