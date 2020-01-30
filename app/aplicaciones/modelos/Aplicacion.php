<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Aplicacion {

    private $id;
    private $sigla;
    private $nombre;
    private $tipo;
    private $seguridad;
    private $tecnologia;
    private $proveedor;
    private $lenguaje;
    private $herramienta;
    private $base;
    private $modo;
    private $lugar;
    private $plataforma;
    private $gerencia;
    private $empleado;
    private $sProduccion;
    private $sTest;
    private $sDesarrollo;
    private $pProduccion;
    private $pTest;
    private $pDesarrollo;
    private $confidencialidad;
    private $integridad;
    private $disponibilidad;
    private $criticidad;
    private $rti;
    private $descripcion;
    private $estado;
    private $mensaje;

    public function __construct($id = NULL, $sigla = NULL, $nombre = NULL, $tipo = NULL, $seguridad = NULL, $tecnologia = NULL, $proveedor = NULL, $lenguaje = NULL, $herramienta = NULL, $base = NULL, $modo = NULL, $lugar = NULL, $plataforma = NULL, $gerencia = NULL, $empleado = NULL, $sProduccion = NULL, $sTest = NULL, $sDesarrollo = NULL, $pProduccion = NULL, $pTest = NULL, $pDesarrollo = NULL, $confidencialidad = NULL, $integridad = NULL, $disponibilidad = NULL, $criticidad = NULL, $rti = NULL, $descripcion = NULL, $estado = NULL) {
        $this->id = $id;
        $this->sigla = utf8_decode($sigla);
        $this->nombre = utf8_decode($nombre);
        $this->tipo = utf8_decode($tipo);
        $this->seguridad = utf8_decode($seguridad);
        $this->tecnologia = utf8_decode($tecnologia);
        $this->proveedor = $proveedor;
        $this->lenguaje = $lenguaje;
        $this->herramienta = $herramienta;
        $this->base = $base;
        $this->modo = $modo;
        $this->lugar = $lugar;
        $this->plataforma = $plataforma;
        $this->gerencia = $gerencia;
        $this->empleado = $empleado;
        $this->sProduccion = $sProduccion;
        $this->sTest = $sTest;
        $this->sDesarrollo = $sDesarrollo;
        $this->pProduccion = $pProduccion;
        $this->pTest = $pTest;
        $this->pDesarrollo = $pDesarrollo;
        $this->confidencialidad = $confidencialidad;
        $this->integridad = $integridad;
        $this->disponibilidad = $disponibilidad;
        $this->criticidad = $criticidad;
        $this->rti = $rti;
        $this->descripcion = utf8_decode($descripcion);
        $this->estado = $estado;
    }

    public function getId() {
        return $this->id;
    }

    public function getSigla() {
        return utf8_encode($this->sigla);
    }

    public function getNombre() {
        return utf8_encode($this->nombre);
    }

    public function getTipo() {
        return utf8_encode($this->tipo);
    }

    public function getSeguridad() {
        return utf8_encode($this->seguridad);
    }

    public function getTecnologia() {
        return utf8_encode($this->tecnologia);
    }

    public function getProveedor() {
        return $this->proveedor;
    }

    public function getLenguaje() {
        return $this->lenguaje;
    }

    public function getHerramienta() {
        return $this->herramienta;
    }

    public function getBase() {
        return $this->base;
    }

    public function getModo() {
        return $this->modo;
    }

    public function getLugar() {
        return $this->lugar;
    }

    public function getPlataforma() {
        return $this->plataforma;
    }

    public function getGerencia() {
        return $this->gerencia;
    }

    public function getEmpleado() {
        return $this->empleado;
    }

    public function getSProduccion() {
        return $this->sProduccion;
    }

    public function getSTest() {
        return $this->sTest;
    }

    public function getSDesarrollo() {
        return $this->sDesarrollo;
    }

    public function getPProduccion() {
        return $this->pProduccion;
    }

    public function getPTest() {
        return $this->pTest;
    }

    public function getPDesarrollo() {
        return $this->pDesarrollo;
    }

    public function getConfidencialidad() {
        return $this->confidencialidad;
    }

    public function getIntegridad() {
        return $this->integridad;
    }

    public function getDisponibilidad() {
        return $this->disponibilidad;
    }

    public function getCriticidad() {
        return $this->criticidad;
    }

    public function getRti() {
        return $this->rti;
    }

    public function getDescripcion() {
        return utf8_encode($this->descripcion);
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setSigla($sigla) {
        $this->sigla = utf8_decode($sigla);
    }

    public function setNombre($nombre) {
        $this->nombre = utf8_decode($nombre);
    }

    public function setTipo($tipo) {
        $this->tipo = utf8_decode($tipo);
    }

    public function setSeguridad($seguridad) {
        $this->seguridad = utf8_decode($seguridad);
    }

    public function setTecnologia($tecnologia) {
        $this->tecnologia = utf8_decode($tecnologia);
    }

    public function setProveedor($proveedor) {
        $this->proveedor = $proveedor;
    }

    public function setLenguaje($lenguaje) {
        $this->lenguaje = $lenguaje;
    }

    public function setHerramienta($herramienta) {
        $this->herramienta = $herramienta;
    }

    public function setBase($base) {
        $this->base = $base;
    }

    public function setModo($modo) {
        $this->modo = $modo;
    }

    public function setLugar($lugar) {
        $this->lugar = $lugar;
    }

    public function setPlataforma($plataforma) {
        $this->plataforma = $plataforma;
    }

    public function setGerencia($gerencia) {
        $this->gerencia = $gerencia;
    }

    public function setEmpleado($empleado) {
        $this->empleado = $empleado;
    }

    public function setSProduccion($sProduccion) {
        $this->sProduccion = $sProduccion;
    }

    public function setSTest($sTest) {
        $this->sTest = $sTest;
    }

    public function setSDesarrollo($sDesarrollo) {
        $this->sDesarrollo = $sDesarrollo;
    }

    public function setPProduccion($pProduccion) {
        $this->pProduccion = $pProduccion;
    }

    public function setPTest($pTest) {
        $this->pTest = $pTest;
    }

    public function setPDesarrollo($pDesarrollo) {
        $this->pDesarrollo = $pDesarrollo;
    }

    public function setConfidencialidad($confidencialidad) {
        $this->confidencialidad = $confidencialidad;
    }

    public function setIntegridad($integridad) {
        $this->integridad = $integridad;
    }

    public function setDisponibilidad($disponibilidad) {
        $this->disponibilidad = $disponibilidad;
    }

    public function setCriticidad($criticidad) {
        $this->criticidad = $criticidad;
    }

    public function setRti($rti) {
        $this->rti = $rti;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = utf8_decode($descripcion);
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function cambiarEstado() {
        if ($this->id && $this->estado) {
            $consulta = "UPDATE apl_aplicacion SET estado = ? WHERE id = ?";
            $modificacion = SQLServer::instancia()->modificar($consulta, array(&$this->estado, &$this->id));
            $this->mensaje = SQLServer::instancia()->getMensaje();
            if ($modificacion == 2) {
                $operacion = ($this->estado == "Activa") ? "ALTA" : "BAJA";
                $modificacion = $this->registrarActividad($operacion, $this->id);
            }
            return $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function crear() {
        if ($this->sigla && $this->nombre && $this->tipo && $this->seguridad && $this->tecnologia && $this->modo && $this->lugar) {
            $consulta = "INSERT INTO apl_aplicacion OUTPUT INSERTED.id VALUES (?,?,?,?,?,?,?,?,?,?,?,?,NULL,?,NULL,NULL,?,NULL,NULL,?,NULL,NULL,NULL,NULL,?,?,'Activa')";
            $datos = array(&$this->sigla, &$this->nombre, &$this->tipo, &$this->seguridad, &$this->tecnologia, &$this->proveedor, &$this->lenguaje, &$this->herramienta, &$this->base, &$this->modo, &$this->lugar, &$this->plataforma, &$this->empleado, &$this->sDesarrollo, &$this->pDesarrollo, &$this->rti, &$this->descripcion);
            $creacion = SQLServer::instancia()->insertar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            if ($creacion == 2) {
                $this->id = SQLServer::instancia()->getUltimoId();
                $creacion = $this->registrarActividad("CREACION", $this->id);
            }
            return $creacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    /**
     * Permite modificar los datos correspondientes a Sistemas.
     */
    public function modificarPP() {
        if ($this->id) {
            $consulta = "UPDATE apl_aplicacion SET sigla=?, nombre=?, tipo=?, seguridad=?, tecnologia=?, proveedor=?, lenguaje=?, herramienta=?, base=?, modoProcesamiento=?, lugarProcesamiento=?, plataforma=?, empleado=?, servidorDesarrollo=?, puertoDesarrollo=?, rti=?, descripcion=? WHERE id=?";
            $datos = array(&$this->sigla, &$this->nombre, &$this->tipo, &$this->seguridad, &$this->tecnologia, &$this->proveedor, &$this->lenguaje, &$this->herramienta, &$this->base, &$this->modo, &$this->lugar, &$this->plataforma, &$this->empleado, &$this->sDesarrollo, &$this->pDesarrollo, &$this->rti, &$this->descripcion, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return ($modificacion == 2) ? $this->registrarActividad("MODIFICACION", $this->id) : $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    /**
     * Permite modificar los datos correspondientes a Tecnologia.
     */
    public function modificarSP() {
        if ($this->id && $this->nombre) {
            $consulta = "UPDATE apl_aplicacion SET servidorProduccion=?, servidorTest=?, puertoProduccion=?, puertoTest=? WHERE id=?";
            $datos = array(&$this->sProduccion, &$this->sTest, &$this->pProduccion, &$this->pTest, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return ($modificacion == 2) ? $this->registrarActividad("MODIFICACION", $this->id) : $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    /**
     * Permite modificar los datos correspondientes a Proteccion de Activos de la Informacion.
     */
    public function modificarTP() {
        if ($this->id && $this->confidencialidad && $this->integridad && $this->disponibilidad && $this->criticidad) {
            $consulta = "UPDATE apl_aplicacion SET confidencialidad=?, integridad=?, disponibilidad=?, criticidad=? WHERE id=?";
            $datos = array(&$this->confidencialidad, &$this->integridad, &$this->disponibilidad, &$this->criticidad, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return ($modificacion == 2) ? $this->registrarActividad("MODIFICACION", $this->id) : $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM apl_aplicacion WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (gettype($fila) == "array") {
                $this->sigla = $fila['sigla'];
                $this->nombre = $fila['nombre'];
                $this->tipo = $fila['tipo'];
                $this->seguridad = $fila['seguridad'];
                $this->tecnologia = $fila['tecnologia'];
                $pro = ($fila['proveedor']) ? $this->obtenerProveedor($fila['proveedor']) : 2;
                $len = ($fila['lenguaje']) ? $this->obtenerLenguaje($fila['lenguaje']) : 2;
                $her = ($fila['herramienta']) ? $this->obtenerHerramienta($fila['herramienta']) : 2;
                $bas = ($fila['base']) ? $this->obtenerBase($fila['base']) : 2;
                $mod = $this->obtenerModo($fila['modoProcesamiento']);
                $lug = $this->obtenerLugar($fila['lugarProcesamiento']);
                $pla = ($fila['plataforma']) ? $this->obtenerPlataforma($fila['plataforma']) : 2;
                $ger = ($fila['gerencia']) ? $this->obtenerGerencia($fila['gerencia']) : 2;
                $emp = ($fila['empleado']) ? $this->obtenerEmpleado($fila['empleado']) : 2;
                $spr = ($fila['servidorProduccion']) ? $this->obtenerServidorProduccion($fila['servidorProduccion']) : 2;
                $ste = ($fila['servidorTest']) ? $this->obtenerServidorTest($fila['servidorTest']) : 2;
                $sde = ($fila['servidorDesarrollo']) ? $this->obtenerServidorDesarrollo($fila['servidorDesarrollo']) : 2;
                $this->pProduccion = $fila['puertoProduccion'];
                $this->pTest = $fila['puertoTest'];
                $this->pDesarrollo = $fila['puertoDesarrollo'];
                $this->confidencialidad = $fila['confidencialidad'];
                $this->integridad = $fila['integridad'];
                $this->disponibilidad = $fila['disponibilidad'];
                $this->criticidad = $fila['criticidad'];
                $this->rti = $fila['rti'];
                $this->descripcion = $fila['descripcion'];
                $this->estado = $fila['estado'];
                $res = (($pro == 2) && ($len == 2) && ($her == 2) && ($bas == 2) && ($mod == 2) && ($lug == 2) && ($pla == 2) && ($ger == 2) && ($emp == 2) && ($spr == 2) && ($ste == 2) && ($sde == 2)) ? 2 : 1;
                return $res;
            }
            $this->mensaje = "No se obtuvo la información de la aplicación";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia a la aplicación";
        return 0;
    }

    private function obtenerProveedor($idProveedor) {
        $proveedor = new Proveedor($idProveedor);
        $resultado = $proveedor->obtener();
        $this->proveedor = ($resultado == 2) ? $proveedor : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener el proveedor";
        return $resultado;
    }

    private function obtenerLenguaje($idLenguaje) {
        $lenguaje = new LenguajeProgramacion($idLenguaje);
        $resultado = $lenguaje->obtener();
        $this->lenguaje = ($resultado == 2) ? $lenguaje : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener el lenguaje de programación";
        return $resultado;
    }

    private function obtenerHerramienta($idHerramienta) {
        $herramienta = new HerramientaDesarrollo($idHerramienta);
        $resultado = $herramienta->obtener();
        $this->herramienta = ($resultado == 2) ? $herramienta : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener la herramienta de desarrollo";
        return $resultado;
    }

    private function obtenerBase($idBase) {
        return 2;
    }

    private function obtenerModo($idModo) {
        $modo = new ModoProcesamiento($idModo);
        $resultado = $modo->obtener();
        $this->modo = ($resultado == 2) ? $modo : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener el modo de procesamiento";
        return $resultado;
    }

    private function obtenerLugar($idLugar) {
        $lugar = new LugarProcesamiento($idLugar);
        $resultado = $lugar->obtener();
        $this->lugar = ($resultado == 2) ? $lugar : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener el lugar de procesamiento";
        return $resultado;
    }

    private function obtenerPlataforma($idPlataforma) {
        $plataforma = new PlataformaSO($idPlataforma);
        $resultado = $plataforma->obtener();
        $this->plataforma = ($resultado == 2) ? $plataforma : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener la plataforma SO";
        return $resultado;
    }

    private function obtenerGerencia($idGerencia) {
        $gerencia = new Gerencia($idGerencia);
        $resultado = $gerencia->obtener();
        $this->gerencia = ($resultado == 2) ? $gerencia : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener la gerencia";
        return $resultado;
    }

    private function obtenerEmpleado($idEmpleado) {
        $empleado = new Empleado($idEmpleado);
        $resultado = $empleado->obtener();
        $this->empleado = ($resultado == 2) ? $empleado : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener la persona delegada";
        return $resultado;
    }

    private function obtenerServidorProduccion($idProduccion) {
        $produccion = new Servidor($idProduccion);
        $resultado = $produccion->obtener();
        $this->sProduccion = ($resultado == 2) ? $produccion : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener servidor de producción";
        return $resultado;
    }

    private function obtenerServidorTest($idTest) {
        $test = new Servidor($idTest);
        $resultado = $test->obtener();
        $this->sTest = ($resultado == 2) ? $test : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener servidor de test";
        return $resultado;
    }

    private function obtenerServidorDesarrollo($idDesarrollo) {
        return 2;
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("apl_aplicacion", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
