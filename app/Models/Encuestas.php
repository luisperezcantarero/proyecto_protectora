<?php
namespace App\Models;

class Encuestas extends DBAbstractModel {
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
    private $fecha_envio;
    private $fecha_respuesta;
    private $estado_salud_id;
    private $adaptacion_id;
    private $comentarios;
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
    public function setFechaEnvio($fecha_envio) {
        $this->fecha_envio = $fecha_envio;
    }
    public function setFechaRespuesta($fecha_respuesta) {
        $this->fecha_respuesta = $fecha_respuesta;
    }
    public function setEstadoSaludId($estado_salud_id) {
        $this->estado_salud_id = $estado_salud_id;
    }
    public function setAdaptacionId($adaptacion_id) {
        $this->adaptacion_id = $adaptacion_id;
    }
    public function setComentarios($comentarios) {
        $this->comentarios = $comentarios;
    }
    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }
    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }

    public function getEncuestaExistente($adopcion_id) {
        $this->query = "SELECT id FROM encuestas WHERE adopcion_id = :adopcion_id";
        $this->parametros['adopcion_id'] = $adopcion_id;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return true;
        } else {
            return false;
        }
    }

    // guardar encuesta
    public function set() {
        $this->query = "INSERT INTO encuestas (adopcion_id, fecha_envio, fecha_respuesta, estado_salud_id, adaptacion_id, comentarios, created_at, updated_at) 
                        VALUES (:adopcion_id, :fecha_envio, :fecha_respuesta, :estado_salud_id, :adaptacion_id, :comentarios, :created_at, :updated_at)";
        $this->parametros['adopcion_id'] = $this->adopcion_id;
        $this->parametros['fecha_envio'] = $this->fecha_envio;
        $this->parametros['fecha_respuesta'] = $this->fecha_respuesta;
        $this->parametros['estado_salud_id'] = $this->estado_salud_id;
        $this->parametros['adaptacion_id'] = $this->adaptacion_id;
        $this->parametros['comentarios'] = $this->comentarios;
        $this->parametros['created_at'] = date('Y-m-d H:i:s');
        $this->parametros['updated_at'] = date('Y-m-d H:i:s');
        $this->get_results_from_query();
    }

    public function getEstadosSalud() {
        $this->query = "SELECT id, nombre FROM t_estados_salud";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getAdaptaciones() {
        $this->query = "SELECT id, nombre FROM t_adaptaciones";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function get($id = '') {}
    public function edit() {}
    public function delete($id = '') {}
}
?>