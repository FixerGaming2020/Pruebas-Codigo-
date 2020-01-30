<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$resultado = "";
if ($_POST['metodo']) {
    $encripta = new Encriptador();
    if ($_POST['metodo'] == "encriptar") {
        $cadena = $_POST['cadenaEncriptar'];
        $clave = $_POST['keyEncriptar'];
        $resultado = $encripta->encriptar($cadena, $clave);
    } else {
        $cadena = $_POST['cadenaDesencriptar'];
        $clave = $_POST['keyDesencriptar'];
        $resultado = $encripta->desencriptar($cadena, $clave);
    }
}
echo $resultado;
