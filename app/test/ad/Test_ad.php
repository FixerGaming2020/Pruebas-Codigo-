<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../../principal/modelos/Constantes.php';
include_once '../../principal/modelos/Log.php';
include_once '../../principal/modelos/ActiveDirectory.php';


$ad = new ActiveDirectory(LDAP_HOST, LDAP_PORT, LDAP_DOMI);
if ($ad->conectar()) {
    $usuario = "07195";
    $clave = "07195";
    if ($ad->buscar($usuario, $clave)) {
        echo "CONECTADO";
        
           
    } else {
        echo $ad->getMensaje();
    }
} else {
    echo $ad->getMensaje();
} 

/*
$ad = new ActiveDirectory(LDAP_HOST, LDAP_PORT, LDAP_DOMI);
$usuario = "07197";
$clave = "07197";
if ($ad->buscar($usuario, $clave)) {
    echo "CONECTADO";
} else {
    echo $ad->getMensaje();
}
 
 */