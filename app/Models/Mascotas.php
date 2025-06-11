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
    // Attributes
    private $id;
    private $nombre;
    private $tipoAnimal;
    private $raza;
    private $edad;
    private $propietario_id;

    // Setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function setTipoAnimal($tipoAnimal) {
        $this->tipoAnimal = $tipoAnimal;
    }
    public function setRaza($raza) {
        $this->raza = $raza;
    }
    public function setEdad($edad) {
        $this->edad = $edad;
    }
    public function setPropietarioId($propietario_id) {
        $this->propietario_id = $propietario_id;
    }
    // Getters
    public function getId() {
        return $this->id;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function getTipoAnimal() {
        return $this->tipoAnimal;
    }
    public function getRaza() {
        return $this->raza;
    }
    public function getEdad() {
        return $this->edad;
    }
    public function getPropietarioId() {
        return $this->propietario_id;
    }
    // Methods
    public function set() {
        $this->query = "INSERT INTO mascotas (nombre, tipoAnimal, raza, edad, propietario_id) 
                        VALUES (:nombre, :tipoAnimal, :raza, :edad, :propietario_id)";
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['tipoAnimal'] = $this->tipoAnimal;
        $this->parametros['raza'] = $this->raza;
        $this->parametros['edad'] = $this->edad;
        // Si propietario_id es null, pasarlo como null
        $this->parametros['propietario_id'] = $this->propietario_id !== null ? $this->propietario_id : null;
        $this->get_results_from_query();
    }

    public function get($id = '') {
        $this->query = "SELECT * FROM mascotas WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = "Mascota obtenida";
    }

    public function edit() {
        $this->query = "UPDATE mascotas SET nombre = :nombre, tipoAnimal = :tipoAnimal, 
                        raza = :raza, edad = :edad, propietario_id = :propietario_id 
                        WHERE id = :id";
        $this->parametros['id'] = $this->id;
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['tipoAnimal'] = $this->tipoAnimal;
        $this->parametros['raza'] = $this->raza;
        $this->parametros['edad'] = $this->edad;
        $this->parametros['propietario_id'] = $this->propietario_id;
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
        $this->query = "SELECT * FROM mascotas WHERE nombre LIKE :filter OR tipoAnimal LIKE :filter OR raza LIKE :filter OR edad LIKE :filter";
        $this->parametros['nombre'] = '%' . $filter . '%';
        $this->parametros['tipoAnimal'] = '%' . $filter . '%';
        $this->parametros['raza'] = '%' . $filter . '%';
        $this->parametros['edad'] = '%' . $filter . '%';
        $this->get_results_from_query();
        $this->mensaje = "Mascotas filtradas";
        return $this->rows;
    }

    public function getMascota() {
        $this->query = "SELECT * FROM mascotas WHERE id = :id";
        $this->parametros['id'] = $this->id;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            $this->mensaje = "Mascota encontrada";
            return $this->rows[0];
        } else {
            $this->mensaje = "Mascota no encontrada";
            return null;
        }
    }

    public function getMascotaByPropietarioId($propietario_id) {
        $this->query = "SELECT * FROM mascotas WHERE propietario_id = :propietario_id";
        $this->parametros['propietario_id'] = $propietario_id;
        $this->get_results_from_query();
        $this->mensaje = "Mascotas por propietario obtenidas";
        return $this->rows;
    }
}
?>