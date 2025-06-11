<?php
namespace App\Models;

class Propietario extends DBAbstractModel {
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
    private $nombre;
    private $usuario_id;
    private $message = '';

    public function getNombre() {
        return $this->nombre;
    }

    public function getNombreById($id) {
        $this->query = "SELECT nombre FROM propietarios WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows[0]['nombre'];
        } else {
            return null;
        }
    }

    // Función para crear un nuevo propietario
    public function setPropietario($usuario_id, $nombre = null) {
        // Verificar si el usuario ya es un propietario
        $this->query = "SELECT * FROM propietarios WHERE usuario_id = :usuario_id";
        $this->parametros['usuario_id'] = $usuario_id;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            $this->message = 'Ya eres es un propietario.';
            return false;
        }
        // Insertar nuevo propietario
        $this->query = "INSERT INTO propietarios (nombre, usuario_id) VALUES (:nombre, :usuario_id)";
        $this->parametros['nombre'] = $nombre;
        $this->parametros['usuario_id'] = $usuario_id;
        $this->get_results_from_query();
        $this->message = 'Propietario creado correctamente.';
        return true;
    }

    // Comprobar si un usuario es propietario
    public function isPropietario($usuario_id) {
        $this->query = "SELECT * FROM propietarios WHERE usuario_id = :usuario_id";
        $this->parametros['usuario_id'] = $usuario_id;
        $this->get_results_from_query();
        return count($this->rows) > 0; // Devuelve true si es propietario, false si no lo es
    }

    // Funcion para obtener el mensaje
    public function getMessage() {
        return $this->message;
    }

    public function get($id = '') {}
    public function set() {}
    public function edit() {}
    public function delete() {}
}
?>