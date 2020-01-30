<?php


require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$usuario = new Usuario();

$usuario->setId('07489');

$resultado = $usuario->obtener();

echo "RESULTADO: ".$resultado."<br>";

echo $usuario->getPerfil()->getNombre()."<br>";

echo '<pre>';
var_dump($usuario);
echo '<pre>';