<?php

$host = "ldap://192.168.250.150";
$puerto = 389;
$dominio = "desarrollo\\";

$conexion = ldap_connect($host, $puerto);
if ($conexion) {
    ldap_set_option($conexion, LDAP_OPT_PROTOCOL_VERSION, 3);
    $user = $dominio . "07197";
    $clave = "07197";
    if (@ldap_bind($conexion, $user, $clave)) {
        $ldap_base_dn = 'DC=desapdc01, DC=net';
        $search_filter = '(&(objectCategory=group))';
        $attributes = array();
        $attributes[] = 'samaccountname';
        $attributes[] = 'sn';
        $attributes[] = 'description';
        $attributes[] = 'member';
        $result = ldap_search($conexion, $ldap_base_dn, $search_filter, $attributes);
        if (FALSE !== $result) {
            $entries = ldap_get_entries($conexion, $result);
            echo '<BR> TOTAL DE GRUPOS --- ' . count($entries) . "<br>";
            for ($x = 0; $x < $entries['count']; $x++) {
                $countname = (empty($entries[$x]['samaccountname'][0])) ? "" : $entries[$x]['samaccountname'][0];
                $description = (empty($entries[$x]['description'][0])) ? "" : $entries[$x]['description'][0];
                $dn = (empty($entries[$x]['dn'][0])) ? "" : $entries[$x]['dn'];
                $members = (empty($entries[$x]['member'][0])) ? "" : $entries[$x]['member']["count"];
                echo "<br><B>GRUPO N° " . ($x + 1) . " </B><br>";
                echo "Nombre grupo: " . $countname . "<br>";
                echo "Descripción: " . $description . "<br>";
                echo "Miembros: " . $members . "<br>";
                echo "DN: " . $dn . "<br>";
            }
        } else {
            echo '<br> BUSQUEDA SIN RESULTADOS';
        }
        ldap_unbind($conexion); // Clean up after ourselves.
    } else {
        echo "<br> USUARIO INCORRECTO";
    }
} else {
    echo "<br> NO HAY CONEXION";
}