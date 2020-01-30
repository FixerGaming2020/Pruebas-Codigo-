<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorHTML {

    public static function getAlertaOperacion($resultado, $mensaje) {
        switch ($resultado) {
            case 2:
                $icono = "<i class='far fa-check-circle'></i>";
                $clase = 'class="alert alert-success text-center"';
                break;
            case 1:
                $icono = "<i class='fas fa-exclamation-circle'></i>";
                $clase = 'class="alert alert-warning text-center"';
                break;
            case 0:
                $icono = "<i class='fas fa-exclamation-triangle'></i>";
                $clase = 'class="alert alert-danger text-center"';
                break;
        }
        return "<div {$clase} role='alert'>{$icono} <strong>{$mensaje}</strong></div>";
    }

    public static function getCard($cuerpo, $titulo) {
        return ' <div class="card border-azul-clasico">
                    <div class="card-header bg-azul-clasico text-white">' . $titulo . '</div>
                    <div class="card-body">' . $cuerpo . '</div>
                </div>';
    }

    public static function getCardBusqueda($filtro, $cuerpo) {
        return ' <div class="card border-azul-clasico">
                    <div class="card-header bg-azul-clasico text-white">
                        <i class="fas fa-table"></i> ' . $filtro . '</div>
                    <div class="card-body">' . $cuerpo . '</div>
                </div>';
    }

}
