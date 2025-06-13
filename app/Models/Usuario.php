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
    private $nombre;
    private $email;
    private $password;
    private $rol_id;
    private $bloqueado;
    private $created_at;
    private $update_at;
    private $token;
    private $token_created_at;
    private $intentos_fallidos;
    private $message;

    // Setters
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    public function setRol($rol_id) {
        $this->rol_id = $rol_id;
    }
    public function setBloqueo($bloqueado) {
        $this->bloqueado = $bloqueado;
    }
    public function setToken($token) {
        $this->token = $token;
    }
    // Getters
    public function getId() {
        return $this->id;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getRol() {
        return $this->rol_id;
    }
    public function getBloqueo() {
        return $this->bloqueo;
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
        $this->query = "INSERT INTO usuarios (nombre, email, password, rol_id, bloqueado, created_at, updated_at, token, token_created_at, intentos_fallidos) VALUES (:nombre, :email, :password, :rol_id, :bloqueado, :created_at, :updated_at, :token, :token_created_at, :intentos_fallidos)";
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['email'] = $this->email;
        $this->parametros['password'] = $this->password;
        $this->parametros['rol_id'] = $this->rol_id;
        $this->parametros['bloqueado'] = $this->bloqueado;
        $this->parametros['created_at'] = date('Y-m-d H:i:s');
        $this->parametros['updated_at'] = date('Y-m-d H:i:s');
        $this->parametros['token'] = $this->token;
        $this->parametros['token_created_at'] = date('Y-m-d H:i:s');
        $this->parametros['intentos_fallidos'] = 0;
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
                    $this->nombre = $usuario['nombre'];
                    $this->email = $usuario['email'];
                    $this->password = $usuario['password'];
                    $this->rol_id = $usuario['rol_id'];
                    $this->bloqueado = $usuario['bloqueado'];
                    $this->created_at = $usuario['created_at'];
                    $this->update_at = $usuario['update_at'];
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
        $this->query = "SELECT rol_id FROM usuarios WHERE email = :email";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows[0]['rol_id'];
        } else {
            return null;
        }
    }

    public function getIntentosFallidos($email) {
        $this->query = "SELECT intentos_fallidos FROM usuarios WHERE email = :email";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows[0]['intentos_fallidos'];
        } else {
            return 0; // Si no se encuentra el usuario, devolvemos 0 intentos fallidos
        }
    }

    public function setIntentosFallidos($email, $intentos) {
        $this->query = "UPDATE usuarios SET intentos_fallidos = :intentos_fallidos WHERE email = :email";
        $this->parametros['intentos_fallidos'] = $intentos;
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        $this->message = 'Intentos fallidos actualizados correctamente.';
    }

    // Método para bloquear un usuario
    public function ActualizarBloqueoUsuario($email) {
        $this->query = "UPDATE usuarios SET bloqueado = :bloqueado WHERE email = :email";
        $this->parametros['bloqueado'] = $this->bloqueado;
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        $this->message = 'Usuario bloqueado correctamente.';
    }

    // Método para verificar si un usuario está bloqueado
    public function isBloqueado($email) {
        $this->query = "SELECT bloqueado FROM usuarios WHERE email = :email";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        if (count($this->rows) == 1) {
            $usuario = $this->rows[0];
            if ($usuario['bloqueado'] === 1) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    // Método para obtener usuarios bloqueados
    public function getUsuariosBloqueados() {
        $this->query = "SELECT * FROM usuarios WHERE bloqueado = 1";
        $this->get_results_from_query();
        if (is_array($this->rows)) {
            return $this->rows;
        } else {
            return [];
        }
    }

    // Método para obtener usuario por email
    public function getUserByEmail($email) {
        $this->query = "SELECT nombre FROM usuarios WHERE email = :email";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows[0]['nombre'];
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