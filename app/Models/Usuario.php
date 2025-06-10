<?php
namespace App\Models;

class Usuario extends DBAbstractModel {
    // Modelo Singleton
    private static $instance;
    public static function getInstance() {
        if (!isset(self::$instance)) {
            $myClass = __CLASS__;
            self::$instance = new $myClass;
        }
        return self::$instance;
    }
    public function __clone() {
        trigger_error('La clonación no está permitida.', E_USER_ERROR);
    }
    // Atributos
    private $id;
    private $user;
    private $email;
    private $password;
    private $created_at;
    private $update_at;
    private $user_profile;
    // private $token; // Si se necesita un token para autenticación
    // private $token_created_at; // Si se necesita un timestamp para el token

    // Setters
    public function setUser($user) {
        $this->user = $user;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    public function setUserProfile($user_profile) {
        $this->user_profile = $user_profile;
    }
    // Getters
    public function getUser() {
        return $this->user;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getPassword() {
        return $this->password;
    }
    // Métodos
    // Método set
    public function set() {
        // Verificar si el email ya existe
        $this->query = "SELECT * FROM usuarios WHERE email = :email";
        $this->parametros['email'] = $this->email;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            $this->message = 'El email ya ha sido registrado.';
            return false;
        }
        // Si no existe, insertar el nuevo usuario
        $this->query = "INSERT INTO usuarios (user, email, password, user_profile) VALUES (:user, :email, :password, :user_profile)";
        $this->parametros['user'] = $this->user;
        $this->parametros['email'] = $this->email;
        $this->parametros['password'] = $this->password;
        $this->parametros['created_at'] = date('Y-m-d H:i:s');
        $this->parametros['update_at'] = date('Y-m-d H:i:s');
        $this->parametros['user_profile'] = $this->user_profile;
        $this->get_results_from_query();
        $this->message = 'Usuario registrado correctamente.';
    }

    // Método login
    public function login($email, $password) {
        $this->query = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        if (count($this->rows) == 1) {
            $usuario = $this->rows[0];
            // Comprobamos que la contraseña coincide con la almacenada en la base de datos
            if ($password === $usuario['password']) {
                $this->id = $usuario['id'];
                $this->user = $usuario['user'];
                $this->email = $usuario['email'];
                $this->password = $usuario['password'];
                $this->created_at = $usuario['created_at'];
                $this->update_at = $usuario['update_at'];
                $this->user_profile = $usuario['user_profile'];
                return true;
            }
        }
        return false;
    }


    // Método para obtener el perfil de usuario
    public function getUserProfile($email) {
        $this->query = "SELECT user_profile FROM usuarios WHERE email = :email";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows[0]['user_profile'];
        } else {
            return null;
        }
    }

    // Método para obtener usuario por email
    public function getUserByEmail($email) {
        $this->query = "SELECT user FROM usuarios WHERE email = :email";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows[0]['user'];
        } else {
            return null;
        }
    }

    protected function get() {}
    protected function edit() {}
    protected function delete() {}
}
?>