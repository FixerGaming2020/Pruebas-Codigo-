<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorPermiso();
$menus = $controlador->listarPorNivel(1);
$submenus = $controlador->listarPorNivel(2);


while ($menu = sqlsrv_fetch_array($menus, SQLSRV_FETCH_ASSOC)) {
    echo '<br>' . $menu['id'] . " " . $menu['titulo'];
    $cantidad = sqlsrv_num_rows($submenus);
    for ($index = 0; $index < $cantidad; $index++) {

        $submenu = sqlsrv_fetch_array($submenus, SQLSRV_FETCH_ASSOC, SQLSRV_SCROLL_ABSOLUTE, $index);
        if ($submenu['padre'] == $menu['id']) {
            echo '<br>__' . $submenu['id'] . " " . $submenu['titulo'] . " " . $submenu['padre'] . " " . $submenu['link'] . " " . $submenu['formulario'];
        }
    }
} 

/*
echo "<br><br><br> " . sqlsrv_num_fields($menu);
while ($menu = sqlsrv_fetch_array($menus, SQLSRV_FETCH_ASSOC)) {
    echo '<br>' . $menu['id'] . " " . $menu['titulo'];
    $submenu = sqlsrv_fetch_array($submenus, SQLSRV_FETCH_ASSOC);
    do {
        if ($submenu['padre'] == $menu['id']) {
            echo '<br>__' . $submenu['id'] . " " . $submenu['titulo'] . " " . $submenu['padre'] . " " . $submenu['link'] . " " . $submenu['formulario'];
        }
    } while ($submenu = sqlsrv_fetch_array($submenus, SQLSRV_FETCH_ASSOC));
    $submenu = sqlsrv_fetch_row($submenus, SQLSRV_FETCH_BOTH, SQLSRV_SCROLL_FIRST);
}
*/