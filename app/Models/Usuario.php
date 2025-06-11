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
    private $token;
    private $token_created_at;

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
    public function setToken($token) {
        $this->token = $token;
    }
    // Getters
    public function getId() {
        return $this->id;
    }
    public function getUser() {
        return $this->user;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getMessage() {
        return $this->message;
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
        $this->query = "INSERT INTO usuarios (user, email, password, user_profile, token, token_created_at) VALUES (:user, :email, :password, :user_profile, :token, :token_created_at)";
        $this->parametros['user'] = $this->user;
        $this->parametros['email'] = $this->email;
        $this->parametros['password'] = $this->password;
        $this->parametros['created_at'] = date('Y-m-d H:i:s');
        $this->parametros['update_at'] = date('Y-m-d H:i:s');
        $this->parametros['user_profile'] = $this->user_profile;
        $this->parametros['token'] = $this->token;
        $this->parametros['token_created_at'] = date('Y-m-d H:i:s');
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
                // Comprobamos si el usuario ha verificado su cuenta
                if ($usuario['token'] === null) {
                    // Si la cuenta está verificada, asignamos los valores a los atributos de la clase
                    $this->id = $usuario['id'];
                    $this->user = $usuario['user'];
                    $this->email = $usuario['email'];
                    $this->password = $usuario['password'];
                    $this->created_at = $usuario['created_at'];
                    $this->update_at = $usuario['update_at'];
                    $this->user_profile = $usuario['user_profile'];
                    $this->token = $usuario['token'];
                    $this->token_created_at = $usuario['token_created_at'];
                    return true;
                } else {
                    $this->message = 'Debes verificar tu cuenta antes de iniciar sesión. Revisa tu correo electrónico.';
                }
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

    // Función para obtener el token de un usuario
    public function getToken($token = '') {
        $this->query = "SELECT * FROM usuarios WHERE token = :token";
        $this->parametros['token'] = $token;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            // Comprobar si el token ha expirado
            $this->token_created_at = $this->rows[0]['token_created_at'];
            $actual_date = date('Y-m-d H:i:s');
            $diff = strtotime($actual_date) - strtotime($this->token_created_at);
            if ($diff < 36000) {
                $this->query = "UPDATE usuarios SET token = NULL, token_created_at = NULL WHERE token = :token";
                $this->parametros['token'] = $token;
                $this->get_results_from_query();
                $this->message = 'Usuario autenticado correctamente.';
            } else {
                $this->message = 'El token ha expirado.';
            }
        } else {
            $this->message = 'Token no válido.';
        }
    }

    protected function get() {}
    protected function edit() {}
    protected function delete() {}
}
?>