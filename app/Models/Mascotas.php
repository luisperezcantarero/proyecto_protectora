<?php
namespace App\Models;

class Mascotas extends DBAbstractModel {
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

    private $id;
    private $nombre;
    private $especie;
    private $raza;
    private $edad;
    private $estado_id;
    private $historial_medico;
    private $foto;
    private $fecha_ingreso;
    private $creado_por;
    private $created_at;
    private $updated_at;
    protected $mensaje;

    // Setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function setEspecie($especie) {
        $this->especie = $especie;
    }
    public function setRaza($raza) {
        $this->raza = $raza;
    }
    public function setEdad($edad) {
        $this->edad = $edad;
    }
    public function setEstado($estado_id) {
        $this->estado_id = $estado_id;
    }
    public function setHistorial($historial_medico) {
        $this->historial_medico = $historial_medico;
    }
    public function setFoto($foto) {
        $this->foto = $foto;
    }
    public function setFechaIngreso($fecha_ingreso) {
        $this->fecha_ingreso = $fecha_ingreso;
    }
    public function setCreadoPor($creado_por) {
        $this->creado_por = $creado_por;
    }
    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }
    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }
    // Getters
    public function getMensaje() {
        return $this->mensaje;
    }
    public function getId() {
        return $this->id;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function getEspecie() {
        return $this->especie;
    }
    public function getRaza() {
        return $this->raza;
    }
    public function getEdad() {
        return $this->edad;
    }

    public function set() {
        $this->query = "INSERT INTO mascotas (nombre, especie, raza, edad, estado_id, historial_medico, foto, fecha_ingreso, creado_por) 
                        VALUES (:nombre, :especie, :raza, :edad, :estado_id, :historial_medico, :foto, :fecha_ingreso, :creado_por)";
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['especie'] = $this->especie;
        $this->parametros['raza'] = $this->raza;
        $this->parametros['edad'] = $this->edad;
        $this->parametros['estado_id'] = $this->estado_id;
        $this->parametros['historial_medico'] = $this->historial_medico;
        $this->parametros['foto'] = $this->foto;
        $this->parametros['fecha_ingreso'] = $this->fecha_ingreso;
        $this->parametros['creado_por'] = $this->creado_por;
        $this->get_results_from_query();
    }

    public function get($id = '') {
        $this->query = "SELECT * FROM mascotas WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = "Mascota obtenida";
    }

    public function edit() {
        $this->query = "UPDATE mascotas SET nombre = :nombre, especie = :especie, 
                        raza = :raza, edad = :edad, estado_id = :estado_id, 
                        historial_medico = :historial_medico, foto = :foto, 
                        fecha_ingreso = :fecha_ingreso, creado_por = :creado_por 
                        WHERE id = :id";
        $this->parametros['id'] = $this->id;
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['especie'] = $this->especie;
        $this->parametros['raza'] = $this->raza;
        $this->parametros['edad'] = $this->edad;
        $this->parametros['estado_id'] = $this->estado_id;
        $this->parametros['historial_medico'] = $this->historial_medico;
        $this->parametros['foto'] = $this->foto;
        $this->parametros['fecha_ingreso'] = $this->fecha_ingreso;
        $this->parametros['creado_por'] = $this->creado_por;
        $this->get_results_from_query();
        $this->mensaje = "Mascota actualizada";
    }

    public function delete($id = '') {
        $this->query = "DELETE FROM mascotas WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = "Mascota eliminada";
    }

    public function getAllMascotas() {
        $this->query = "SELECT * FROM mascotas";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getFilterMascotas($filter) {
        $this->query = "SELECT * FROM mascotas WHERE especie LIKE :filter OR raza LIKE :filter OR edad LIKE :filter";
        $this->parametros['filter'] = '%' . $filter . '%';
        $this->get_results_from_query();
        $this->mensaje = "Mascotas filtradas";
        return $this->rows;
    }

    public function getMascota($id) {
        $this->query = "SELECT * FROM mascotas WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            $this->mensaje = "Mascota encontrada";
            return $this->rows[0];
        } else {
            $this->mensaje = "Mascota no encontrada";
            return null;
        }
    }

    public function getMascotaIdByNombre($nombre) {
        $this->query = "SELECT id FROM mascotas WHERE nombre = :nombre";
        $this->parametros['nombre'] = $nombre;
        $this->get_results_from_query();
        if (count($this->rows) === 1) {
            return $this->rows[0]['id'];
        }
        return null;
    }
}
?>