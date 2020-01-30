<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../../principal/modelos/Encriptador.php';

$enc = new Encriptador();
$clave = "ZLorGtdeAahEWrMCmZ/j88JjqqrEz9BYqeBXQV0Zbck=";
echo "<br>" . $enc->desencriptar("ZFdyZUJ2VG9QTlJGWUVQbGQ1UlgyOGowLzJ0OWl3dHp4NFVlWjF5WlorND06OvUG6RyBXqeSt1HZSHCepA8=", $clave);
echo "<br>" . $enc->desencriptar("dHJqL0luT0ZWbVJzM2pnek45cDV4UT09OjrChtgPjWDqdfeNOgUNsMVs", $clave);
echo "<br>" . $enc->desencriptar("cUxuOUtEWEVlYU94VzFqMFFmTklZZz09Ojpce9DB9vBXNGrRFuiYHMo1", $clave);
echo "<br>" . $enc->desencriptar("WTkrb2Y0djdSb0NWQ2c0ZFdaUk9TZz09OjpuC80jxSSAkxZ7ld6ZTzrh", $clave);
echo "<br>" . $enc->encriptar("CAP_BSC", $clave);





$dato = $enc->encriptar("CAP", "ZLorGtdeAahEWrMCmZ/j88JjqqrEz9BYqeBXQV0Zbck=");
echo "<br>BASE ENC: " . $dato;
echo "<br>BASE DES: " . $enc->desencriptar("TnpOZW13dExOSmYyZi9ZalYyUDFOZz09OjoewcdJMzoxVrsG/dTXdvEF", "ZLorGtdeAahEWrMCmZ/j88JjqqrEz9BYqeBXQV0Zbck=");


