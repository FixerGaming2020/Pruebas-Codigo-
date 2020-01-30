<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$perfil = new Perfil();

$perfil->setId(1);


$resultado = $perfil->obtener();

echo "RESULTADO: " . $resultado;

if ($perfil->getPermisos()) {
    echo "<br>" . sqlsrv_num_rows($perfil->getPermisos());
    $permisos = $perfil->getPermisos();
    while ($permiso = sqlsrv_fetch_array($permisos, SQLSRV_FETCH_ASSOC)) {
        echo "<br>" . $permiso['id'] . " " . $permiso['titulo'];
    }
}
