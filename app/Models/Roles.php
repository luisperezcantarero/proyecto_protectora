<?php
namespace App\Models;

class Roles extends DBAbstractModel {
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

    public function getNombre() {
        return $this->nombre;
    }
    public function getMensaje() {
        return $this->mensaje;
    }

    public function getNombreById($id) {
        $this->query = "SELECT nombre FROM roles WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows[0]['nombre'];
        } else {
            return null;
        }
    }

    protected function get($id = '') {}
    protected function set() {}
    protected function edit() {}
    protected function delete() {}
}
?>