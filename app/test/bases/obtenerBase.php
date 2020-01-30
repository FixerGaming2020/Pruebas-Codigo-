<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$base = new BaseDatos('25025100006');

$resultado = $base->obtener();

if ($resultado == 2) {
    echo "<BR>NOMBRE: " . $base->getNombre();
    echo "<BR>CREACION: " . $base->getCreacion();
    echo "<BR>COLLATION: " . $base->getCollation();
    echo "<BR>PROCESO: " . $base->getProceso();
    echo "<BR>RTI: " . $base->getRti();
    echo "<BR>ESTADO: " . $base->getEstado();
} else {
    echo "RESULTADO: " . $resultado;
}