<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$servidor = new Servidor(4);

$resultado = $servidor->obtener();

if ($resultado == 2) {

    echo "<BR>NOMBRE: " . $servidor->getNombre();
    echo "<BR>IP: " . $servidor->getIp();
    echo "<BR>AMBIENTE: " . $servidor->getAmbiente();
    echo "<BR>TIPO: " . $servidor->getTipo();
    echo "<BR>DESCRIPCION: " . $servidor->getDescripcion();
    echo "<BR>ESTADO: " . $servidor->getEstado();
} else {
    echo "RESULTADO: " . $resultado;
}