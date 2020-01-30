<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
*/

$datosConexion = array("Database" => 'CAP', "UID" => 'administrador', "PWD" => 'lamisma');
$conexion = sqlsrv_connect('192.168.250.144', $datosConexion);
if (!$conexion) {
    echo "<BR><BR>NO HAY CONEXION<BR><BR>";
    die(print_r(sqlsrv_errors(), true));
}
