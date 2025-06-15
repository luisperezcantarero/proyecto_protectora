<?php
namespace App\Models;
class Seguimientos extends DBAbstractModel {
    // Model Singleton
    private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $myClass = __CLASS__;
            self::$instance = new $myClass;
        }
        return self::$instance;
    }
    public function __clone() {
        trigger_error('Cloning is not allowed.', E_USER_ERROR);
    }
    // Atributos
    private $id;
    private $adopcion_id;
    private $trabajador_id;
    private $fecha;
    private $tipo_id;
    private $resultado;
    private $observaciones;
    private $created_at;
    private $updated_at;
    protected $mensaje;

    // Setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setAdopcionId($adopcion_id) {
        $this->adopcion_id = $adopcion_id;
    }
    public function setTrabajadorId($trabajador_id) {
        $this->trabajador_id = $trabajador_id;
    }
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    public function setTipoId($tipo_id) {
        $this->tipo_id = $tipo_id;
    }
    public function setResultado($resultado) {
        $this->resultado = $resultado;
    }
    public function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }
    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }
    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }

    public function set() {
        $this->query = "INSERT INTO seguimientos (adopcion_id, trabajador_id, fecha, tipo_id, resultado, observaciones, created_at, updated_at)
                        VALUES (:adopcion_id, :trabajador_id, :fecha, :tipo_id, :resultado, :observaciones, :created_at, :updated_at)";
        $this->parametros['adopcion_id'] = $this->adopcion_id;
        $this->parametros['trabajador_id'] = $this->trabajador_id;
        $this->parametros['fecha'] = $this->fecha;
        $this->parametros['tipo_id'] = $this->tipo_id;
        $this->parametros['resultado'] = $this->resultado;
        $this->parametros['observaciones'] = $this->observaciones;
        $this->parametros['created_at'] = $this->created_at;
        $this->parametros['updated_at'] = $this->updated_at;
        $this->get_results_from_query();
        $this->mensaje = "Seguimiento añadido";
    }

    public function get($id = '') {
        $this->query = "SELECT * FROM seguimientos WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = "Seguimiento obtenido";
        return $this->rows;
    }

    // Obtener todos los tipos de seguimiento
    public function getTiposSeguimiento() {
        $this->query = "SELECT * FROM tipos_seguimiento";
        $this->get_results_from_query();
        return $this->rows;
    }

    // Comprobar si existe una observación
    public function existeObservacion($adopcion_id) {
        $this->query = "SELECT id FROM seguimientos WHERE adopcion_id = :adopcion_id";
        $this->parametros['adopcion_id'] = $adopcion_id;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Obtener observaciones por adopción
    public function getObservacionesPorAdopcion($adopcion_id) {
        $this->query = "SELECT * FROM seguimientos WHERE adopcion_id = :adopcion_id";
        $this->parametros['adopcion_id'] = $adopcion_id;
        $this->get_results_from_query();
        if (!empty($this->rows)) {
            return $this->rows[0];
        } else {
            return null;
        }
    }
    public function edit() {}
    public function delete() {}
}
?>