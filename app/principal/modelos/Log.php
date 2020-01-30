<?php

class Log {

    public static function escribirLineaError($texto) {
        $date = date("H:i:s");
        $url = LOG . "\\" . date("Y_m_d") . ".txt";
        $file = file_exists($url) ? fopen($url, 'a') : fopen($url, 'w');
        $ip = $_SERVER["REMOTE_ADDR"];
        $script = $_SERVER["SCRIPT_NAME"];
        $user = (isset($_SESSION['usuario'])) ? $_SESSION['usuario']->getId() : "";
        $data = "[HORA: {$date}][USUARIO: {$user}][IP: {$ip}][SCRIPT: {$script}][{$texto}]" . PHP_EOL;
        fwrite($file, $data);
    }

    public static function guardarActividad($tabla, $operacion, $registro) {
        if ($tabla && $operacion && $registro) {
            $usuario = (isset($_SESSION['usuario'])) ? $_SESSION['usuario']->getId() : "DESC";
            $consulta = "INSERT INTO log_actividad VALUES (?, ?, ?, ?, GETDATE())";
            $datos = array(&$usuario, &$tabla, &$operacion, &$registro);
            $creacion = SQLServer::instancia()->insertar($consulta, $datos);
            if ($creacion != 2) {
                Log::escribirLineaError(SQLServer::instancia()->getMensaje() . " - " . $tabla . " - " . $operacion . " - " . $registro);
            }
            return $creacion;
        }
        Log::escribirLineaError("No se pudo guardar actividad por falta de datos");
        return 1;
    }

}
