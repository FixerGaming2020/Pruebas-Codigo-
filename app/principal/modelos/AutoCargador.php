<?php

class AutoCargador {

    public static function cargarModulos() {
        spl_autoload_register(function($className) {
            $modulos = array(ACT, APL, AUX, BAS, COM, DEP, FIR, GER, HAR, HER, INS,
                INV, LEN, ROL, PER, PRS, PLA, PRI, PRO, PSA, SER, SRV, SIT, SWI, USU, UTI);
            foreach ($modulos as $modulo) {
                $archivo = AutoCargador::evaluar($modulo, $className);
                if ($archivo) {
                    require_once ($archivo);
                    return;
                }
            }
        });
    }

    private static function evaluar($modulo, $clase) {
        $controlador = $modulo . '\\controladores\\' . $clase . '.php';
        if (file_exists($controlador)) {
            return $controlador;
        }
        $modelo = $modulo . '\\modelos\\' . $clase . '.php';
        return file_exists($modelo) ? $modelo : NULL;
    }

}
