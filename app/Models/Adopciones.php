<?php
namespace App\Models;

class Adopciones extends DBAbstractModel {
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
    private $mascota_id;
    private $adoptante_id;
    private $trabajador_id;
    private $fecha_adopcion;
    private $estado_id;
    private $fecha_cancelacion;
    private $cancelada_por_id;
    private $motivo_cancelacion;
    private $created_at;
    private $updated_at;
    protected $mensaje;
    // Setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setMascotaId($mascota_id) {
        $this->mascota_id = $mascota_id;
    }
    public function setAdoptanteId($adoptante_id) {
        $this->adoptante_id = $adoptante_id;
    }
    public function setTrabajadorId($trabajador_id) {
        $this->trabajador_id = $trabajador_id;
    }
    public function setFechaAdopcion($fecha_adopcion) {
        $this->fecha_adopcion = $fecha_adopcion;
    }
    public function setEstadoId($estado_id) {
        $this->estado_id = $estado_id;
    }
    public function setFechaCancelacion($fecha_cancelacion) {
        $this->fecha_cancelacion = $fecha_cancelacion;
    }
    public function setCanceladaPorId($cancelada_por_id) {
        $this->cancelada_por_id = $cancelada_por_id;
    }
    public function setMotivoCancelacion($motivo_cancelacion) {
        $this->motivo_cancelacion = $motivo_cancelacion;
    }
    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }
    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }
    // Getters
    public function getId() {
        return $this->id;
    }
    public function getMascotaId() {
        return $this->mascota_id;
    }
    public function getAdoptanteId() {
        return $this->adoptante_id;
    }
    public function getTrabajadorId() {
        return $this->trabajador_id;
    }
    public function getFechaAdopcion() {
        return $this->fecha_adopcion;
    }
    public function getEstadoId() {
        return $this->estado_id;
    }
    public function getFechaCancelacion() {
        return $this->fecha_cancelacion;
    }
    public function getCanceladaPorId() {
        return $this->cancelada_por_id;
    }
    public function getMotivoCancelacion() {
        return $this->motivo_cancelacion;
    }
    public function getCreatedAt() {
        return $this->created_at;
    }
    public function getUpdatedAt() {
        return $this->updated_at;
    }
    public function getMensaje() {
        return $this->mensaje;
    }

    public function get($id = '') {
        $this->query = "SELECT * FROM adopciones WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows[0];
        } else {
            $this->mensaje = 'Adopción no encontrada.';
            return null;
        }
    }

    public function set() {
        $this->query = "INSERT INTO adopciones (mascota_id, adoptante_id, trabajador_id, fecha_adopcion, estado_id, created_at, updated_at) 
                        VALUES (:mascota_id, :adoptante_id, :trabajador_id, :fecha_adopcion, :estado_id, :created_at, :updated_at)";
        $this->parametros['mascota_id'] = $this->mascota_id;
        $this->parametros['adoptante_id'] = $this->adoptante_id;
        $this->parametros['trabajador_id'] = $this->trabajador_id;
        $this->parametros['fecha_adopcion'] = $this->fecha_adopcion;
        $this->parametros['estado_id'] = $this->estado_id;
        $this->parametros['fecha_cancelacion'] = $this->fecha_cancelacion;
        $this->parametros['cancelada_por_id'] = $this->cancelada_por_id;
        $this->parametros['motivo_cancelacion'] = $this->motivo_cancelacion;
        $this->parametros['created_at'] = date('Y-m-d H:i:s');
        $this->parametros['updated_at'] = date('Y-m-d H:i:s');
        $this->get_results_from_query();
        $this->mensaje = 'Adopción creada con éxito.';
    }

    public function edit() {
        $this->query = "UPDATE adopciones SET mascota_id = :mascota_id, adoptante_id = :adoptante_id, 
                        trabajador_id = :trabajador_id, fecha_adopcion = :fecha_adopcion, estado_id = :estado_id, 
                        fecha_cancelacion = :fecha_cancelacion, cancelada_por_id = :cancelada_por_id, 
                        motivo_cancelacion = :motivo_cancelacion, updated_at = :updated_at WHERE id = :id";
        $this->parametros['id'] = $this->id;
        $this->parametros['mascota_id'] = $this->mascota_id;
        $this->parametros['adoptante_id'] = $this->adoptante_id;
        $this->parametros['trabajador_id'] = $this->trabajador_id;
        $this->parametros['fecha_adopcion'] = $this->fecha_adopcion;
        $this->parametros['estado_id'] = $this->estado_id;
        $this->parametros['fecha_cancelacion'] = $this->fecha_cancelacion;
        $this->parametros['cancelada_por_id'] = $this->cancelada_por_id;
        $this->parametros['motivo_cancelacion'] = $this->motivo_cancelacion;
        $this->parametros['updated_at'] = date('Y-m-d H:i:s');
        $this->get_results_from_query();
        $this->mensaje = 'Adopción actualizada con éxito.';
    }

    public function delete($id = '') {
        $this->query = "DELETE FROM adopciones WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Adopción eliminada con éxito.';
    }

    public function mascotaAdoptadaAlready($mascota_id) {
        $this->query = "SELECT id FROM adopciones WHERE mascota_id = :mascota_id AND estado_id = 3";
        $this->parametros['mascota_id'] = $mascota_id;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getAdopcionesEnCursoByAdoptante($adoptante_id) {
        $this->query = "SELECT * FROM adopciones WHERE adoptante_id = :adoptante_id AND estado_id = 1";
        $this->parametros['adoptante_id'] = $adoptante_id;
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getFechaAdopcionById($id) {
        $this->query = "SELECT fecha_adopcion FROM adopciones WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows[0]['fecha_adopcion'];
        } else {
            return null;
        }
    }

    public function cancelarAdopcion($id, $motivo_cancelacion, $cancelada_por_id) {
        $this->query = "UPDATE adopciones SET estado_id = :estado_id, fecha_cancelacion = :fecha_cancelacion, 
                        cancelada_por_id = :cancelada_por_id, motivo_cancelacion = :motivo_cancelacion, updated_at = :updated_at 
                        WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->parametros['estado_id'] = 2; // Estado cancelado
        $this->parametros['fecha_cancelacion'] = date('Y-m-d H:i:s');
        $this->parametros['motivo_cancelacion'] = $motivo_cancelacion;
        $this->parametros['cancelada_por_id'] = $cancelada_por_id;
        $this->parametros['updated_at'] = date('Y-m-d H:i:s');
        $this->get_results_from_query();
    }

    public function adopcionPerteneceAUsuario($id, $usuario_id) {
        $this->query = "SELECT id FROM adopciones WHERE id = :id AND adoptante_id = :usuario_id";
        $this->parametros['id'] = $id;
        $this->parametros['usuario_id'] = $usuario_id;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
?>