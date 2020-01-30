<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class FechaRelativa {

    private $fechaInicio;
    private $fechaMedia;

    public function __construct() {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $this->fechaInicio = new DateTime("1900-01-01");
        $this->fechaMedia = new DateTime("1957-01-01");
    }

    public function convertirARelativa($fecha) {
        $date = new DateTime($fecha);
        $diferenciaInicio = $this->fechaInicio->diff($date);
        $diferenciaMedia = $this->fechaInicio->diff($this->fechaMedia);
        return ($diferenciaInicio->days - $diferenciaMedia->days);
    }

    public function convertirAFecha($numero) {
        $diferenciaMedia = $this->fechaInicio->diff($this->fechaMedia);
        $dias = $diferenciaMedia->days + $numero + 1;
        $this->fechaInicio->add(new DateInterval('P' . $dias . 'D'));
        return $this->fechaInicio->format('Y-m-d');
    }

}
