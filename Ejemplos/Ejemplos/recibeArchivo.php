<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



if (isset($_FILES["archivo"])) {

    $resultado = "SE RECIBIO EL ARCHIVO " . $_FILES["archivo"]["tmp_name"] . " (" . $_FILES["archivo"]["name"] . ") <br>";
    $resultado .= "<br> Ponele que cargas la tabla: <br>";
    $resultado .= '
        <table border="1">
            <thead>
                <tr>
                    <th>NOMBRE</th>
                    <th>ESTADO</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>PEPE</td>
                    <td>FALLECIDO</td>
                </tr>
                <tr>
                    <td>LOLO</td>
                    <td>RE MUERTO</td>
                </tr>
            </tbody>
        </table>';
    $resultado .= "<br> Y quedas como crack <br>";
} else {
    $resultado = "NO SE RECIBIO NINGUN ARCHIVO";
}


$json[] = array('resultado' => $resultado);
echo json_encode($json);
