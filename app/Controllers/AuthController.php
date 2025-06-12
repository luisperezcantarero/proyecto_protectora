<?php
namespace App\Controllers;
use App\Models\Usuario;
use App\Models\Roles;
use App\Core\EmailSender;

class AuthController extends BaseController {
    public function IndexAction() {
        $data['location'] = 'index';
        $data['message'] = 'Página principal de protectora';
        $this->renderHTML('../app/views/index_view.php', $data);
    }

    public function registerAction($request) {
        // Si el usuario ya está logueado, redirigir a la página principal
        if (isset($_SESSION['nombre'])) {
            header('Location: /');
        }
        $data['location'] = 'register';
        $data['message'] = 'Registro de usuario';
        $data['error'] = '';

        $procesarFormulario = false;
        $data['nombre'] = $data['email'] = $data['password'] = $data['password2'] = '';
        $data['nombreError'] = $data['emailError'] = $data['passwordError'] = $data['password2Error'] = '';

        $newUser = new Usuario();

        if (!empty($_POST)) {
            $data['nombre'] = $_POST['nombre'];
            $data['email'] = $_POST['email'];
            $data['password'] = $_POST['password'];
            $data['password2'] = $_POST['password2'];

            $procesarFormulario = true;
            // Validar datos del formulario
            if (empty($data['nombre'])) {
                $data['nombreError'] = 'El nombre de usuario es obligatorio.';
                $procesarFormulario = false;
            }

            if (empty($data['email'])) {
                $data['emailError'] = 'El email es obligatorio.';
                $procesarFormulario = false;
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['emailError'] = 'El email no es válido.';
                $procesarFormulario = false;
            }

            if (empty($data['password'])) {
                $data['passwordError'] = 'La contraseña es obligatoria.';
                $procesarFormulario = false;
            }

            if (empty($data['password2'])) {
                $data['password2Error'] = 'La confirmación de contraseña es obligatoria.';
                $procesarFormulario = false;
            } elseif ($data['password'] !== $data['password2']) {
                $data['password2Error'] = 'Las contraseñas no coinciden.';
                $procesarFormulario = false;
            }
        }

        // Procesar el formulario si no hay errores
        if ($procesarFormulario) {

            // Generar un token de sesión
            $randomBytes = random_bytes(32);
            $token = base64_encode($randomBytes);
            $secureToken = uniqid("", true) . $token;

            // Asignar valores al modelo
            $newUser->setNombre($data['nombre']);
            $newUser->setEmail($data['email']);
            $newUser->setPassword($data['password']);
            $newUser->setRol(3); // Asignar perfil de usuario por defecto
            $newUser->setBloqueo(0);
            $newUser->setToken($secureToken);
            $newUser->set();
            
            $emailSender = new EmailSender();
            $emailSender->sendConfirmationEmail($data['nombre'], '', $data['email'], $secureToken);
            
            header('Location: /usuarios/login');
        }

        $this->renderHTML('../app/views/register_view.php', $data);
    }

    public function loginAction($request) {
        $data['location'] = 'login';
        $data['message'] = 'Iniciar sesión';
        $data['email'] = $data['password'] = '';
        $data['error'] = '';
        $data['emailError'] = $data['passwordError'] = '';

        // Inicializar variables
        $procesarFormulario = true;
        $emailValido = true;
        $falloIntento = false;
        $intentos = 0;
        $newUser = Usuario::getInstance();
        $objRol = Roles::getInstance();

        // Si ya está logueado, redirigir a la página principal
        if (isset($_SESSION['nombre'])) {
            header('Location: /');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['email'] = $_POST['email'];
            $data['password'] = $_POST['password'];
            $captcha_input = $_POST['captcha'];

            // Iniciar intentos fallidos
            if ($emailValido) {
                $intentos = $newUser->getIntentosFallidos($data['email']);
            }

            // Validar datos del formulario
            if (empty($data['email'])) {
                $data['emailError'] = 'El email es obligatorio.';
                $procesarFormulario = false;
                $emailValido = false;
                $falloIntento = true;
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['emailError'] = 'El email no es válido.';
                $procesarFormulario = false;
                $emailValido = false;
                $falloIntento = true;
            }
            // Validar contraseña
            if (empty($data['password']) && $emailValido) {
                $data['passwordError'] = 'La contraseña es obligatoria.';
                $procesarFormulario = false;
                $falloIntento = true;
            }

            // Validar captcha
            if ($emailValido) {
                $numsCaptcha = $_SESSION['captcha_nums'];
                $maxNum = max($numsCaptcha);
                if ($captcha_input === '') {
                    $data['error'] = 'Debes completar el captcha.';
                    $procesarFormulario = false;
                } elseif ($captcha_input != $maxNum) {
                    $data['error'] = 'Captcha incorrecto.';
                    $procesarFormulario = false;
                    $falloIntento = true;
                }
            }

            // Comprobar si el usuario está bloqueado
            if ($newUser->isBloqueado($data['email'])) {
                $data['error'] = 'El usuario está bloqueado, contacta con un administrador';
                $procesarFormulario = false;
                $falloIntento = true;
            }

            // Procesar el formulario si no hay errores
            if ($procesarFormulario && $emailValido) {
                // Intentar iniciar sesión
                if ($newUser->login($data['email'], $data['password'])) {
                    $_SESSION['id'] = $newUser->getId();
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['nombre'] = $newUser->getUserByEmail($data['email']);
                    $rol_id = $newUser->getUserProfile($data['email']);
                    $_SESSION['rol'] = $objRol->getNombreById($rol_id);
                    $_SESSION['bloqueado'] = 0; // Asignar bloqueado a 0 si el usuario no está bloqueado
                    $newUser->setIntentosFallidos($data['email'], 0); // Reiniciar intentos fallidos en la base de datos
                    header('Location: /');
                } else {
                    $data['error'] = $newUser->getMessage();
                    $falloIntento = true;
                }
            }
            // Incrementar el contador de intentos fallidos
            if ($falloIntento && $emailValido) {
                $intentos++;
                $newUser->setIntentosFallidos($data['email'], $intentos);
            }

            // Solo bloquear si hay email y se ha superado el número máximo de intentos fallidos
            if ($intentos >= 3 && $emailValido) {
                $newUser->setBloqueo(1);
                $newUser->setEmail($data['email']);
                $newUser->bloquearUsuario($data['email']);
                $newUser->setIntentosFallidos($data['email'], 0);
                $data['error'] = 'Has superado el número máximo de intentos. Tu cuenta ha sido bloqueada.';
            }

            // Generar nuevos números para el captcha
            $nums = range(1, 10);
            shuffle($nums);
            $_SESSION['captcha_nums'] = array_slice($nums, 0, 3);
        } else {
            // GET: Generar captcha si no existe
            if (!isset($_SESSION['captcha_nums'])) {
                $nums = range(1, 10);
                shuffle($nums);
                $_SESSION['captcha_nums'] = array_slice($nums, 0, 3);
            }
        }
        $data['intentos'] = $intentos;
        // Renderizar la vista de login
        $this->renderHTML('../app/views/login_view.php', $data);
    }

    // Método para cerrar sesión
    public function logoutAction() {
        // Destruir la sesión y redirigir a la página principal
        session_destroy();
        header('Location: /');
    }

    public function verifyAction() {
        // Obtener el token de la URL
        $token = explode('/', $_SERVER['REQUEST_URI']);
        // Eliminar los dos primeros elementos del array $token y unirlos en una cadena separada por '/' para almacenarlo en $token
        $token = array_slice($token, 2);
        $token = implode('/', $token);

        // Crear una instancia del modelo Usuario y verificar el token
        $modeloUser = Usuario::getInstance();
        $modeloUser->getToken($token);

        if ($modeloUser->getMessage() === 'Usuario autenticado correctamente.') {
            header('Location: /usuarios/login');
        } else {
            echo "<p>Error: " . $modeloUser->getMessage() . "</p>";
            header('Location: /usuarios/login');
        }
    }
}
?>