<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();


$resultado = "";
if ($_POST['metodo']) {
    $conversor = new FechaRelativa();
    if ($_POST['metodo'] == "relativa") {
        $fecha = $_POST['fecha'];
        $resultado = $conversor->convertirARelativa($fecha);
    } else {
        $numero = $_POST['numero'];
        $resultado = $conversor->convertirAFecha($numero);
    }
}
echo $resultado;
