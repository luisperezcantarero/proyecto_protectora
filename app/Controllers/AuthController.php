<?php
namespace App\Controllers;
use App\Models\Usuario;
use App\Models\Propietario;

class AuthController extends BaseController {
    public function IndexAction() {
        $data['location'] = 'index';
        $data['message'] = 'Página principal de protectora';
        $this->renderHTML('../app/views/index_view.php', $data);
    }

    public function registerAction($request) {
        // Si el usuario ya está logueado, redirigir a la página principal
        if (isset($_SESSION['user'])) {
            header('Location: /');
            exit;
        }
        $data['location'] = 'register';
        $data['message'] = 'Registro de usuario';
        $data['error'] = '';

        $procesarFormulario = false;
        $data['user'] = $data['email'] = $data['password'] = $data['password2'] = '';
        $data['userError'] = $data['emailError'] = $data['passwordError'] = $data['password2Error'] = '';

        $newUser = new Usuario();

        if (!empty($_POST)) {
            $data['user'] = $_POST['user'];
            $data['email'] = $_POST['email'];
            $data['password'] = $_POST['password'];
            $data['password2'] = $_POST['password2'];

            $procesarFormulario = true;
            // Validar datos del formulario
            if (empty($data['user'])) {
                $data['userError'] = 'El nombre de usuario es obligatorio.';
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
            // Asignar valores al modelo
            $newUser->setUser($data['user']);
            $newUser->setEmail($data['email']);
            $newUser->setPassword($data['password']);
            $newUser->setUserProfile('user'); // Asignar perfil de usuario por defecto
            $newUser->set();
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

        $procesarFormulario = true;

        // Si ya está logueado, redirigir a la página principal
        if (isset($_SESSION['user'])) {
            header('Location: /');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['email'] = $_POST['email'];
            $data['password'] = $_POST['password'];

            $newUser = Usuario::getInstance();
            $newOwner = Propietario::getInstance();

            // Validar datos del formulario
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

            // Procesar el formulario si no hay errores
            if ($procesarFormulario) {
                // Intentar iniciar sesión
                if ($newUser->login($data['email'], $data['password'])) {
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['user'] = $newUser->getUserByEmail($data['email']);
                    $_SESSION['user_profile'] = $newUser->getUserProfile($data['email']);
                    $usuario_id = $newUser->getId();
                    $_SESSION['usuario_id'] = $usuario_id;
                    $_SESSION['isPropietario'] = $newOwner->isPropietario($_SESSION['usuario_id']);
                    header('Location: /');
                    exit;
                } else {
                    $data['error'] = 'Email o contraseña incorrectos.';
                }
            }
        }
        // Renderizar la vista de login
        $this->renderHTML('../app/views/login_view.php', $data);
    }

    // Método para cerrar sesión
    public function logoutAction() {
        // Destruir la sesión y redirigir a la página principal
        session_destroy();
        header('Location: /');
        exit;
    }
}
?>