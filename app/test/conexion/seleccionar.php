<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../../principal/modelos/Constantes.php';
require '../../principal/modelos/Log.php';
require '../../principal/modelos/Encriptador.php';
require '../../principal/modelos/ConfiguracionBD.php';
require '../../principal/modelos/SQLServer.php';


$consulta = "  SELECT id, titulo FROM [dbo].[seg_permisos] PER INNER JOIN [dbo].[seg_perfiles_permisos] REL ON REL.permiso = PER.id AND REL.perfil = 1 WHERE PER.nivel = 1";
$resultado = SQLServer::instancia()->seleccionar($consulta);
$arregloMenu = array();
while ($menu = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
    $consultaSM = "  SELECT * FROM [dbo].[seg_permisos] WHERE padre = {$menu['id']}";
    $resultadoSM = SQLServer::instancia()->seleccionar($consultaSM);
    $arregloSubmenu = array();
    if (gettype($resultadoSM) != 'resource') {
        continue;
    }
    while ($submenu = sqlsrv_fetch_array($resultadoSM, SQLSRV_FETCH_ASSOC)) {
        $arregloSubmenu[] = array($submenu['id'], $submenu['titulo'], $submenu['link'], $submenu['formulario']);
    }
    $arregloMenu[] = array($menu['id'], $menu['titulo'], $arregloSubmenu);
}


echo "<pre>";
var_dump($arregloMenu);
echo "</pre>";
