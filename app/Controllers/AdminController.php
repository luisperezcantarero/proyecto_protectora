<?php
namespace App\Controllers;
use App\Models\Usuario;

class AdminController extends BaseController {
    // Método para mostrar la lista de usuarios bloqueados
    public function usuariosBloqueadosAction() {
        // Verificar que el usuario es administrador
        if ($_SESSION['rol'] !== 'admin') {
            header('Location: /');
        }
        $objUsuario = Usuario::getInstance();
        $usuariosBloqueados = $objUsuario->getUsuariosBloqueados();
        $data['bloqueados'] = $usuariosBloqueados;
        $data['checked'] = '';
        // Verificar si se ha enviado el formulario para marcar o desmarcar todos
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['marcar_todos'])) {
                $data['checked'] = 'checked';
            } elseif (isset($_POST['desmarcar_todos'])) {
                $data['checked'] = '';
            }
        }
        $this->renderHTML('../app/views/usuarios_bloqueados_view.php', $data);
    }

    // Método para desbloquear usuarios
    public function desbloquearUsuariosAction() {
        // Verificar que el usuario es administrador
        if ($_SESSION['rol'] !== 'admin') {
            header('Location: /');
        }
        $objUsuario = Usuario::getInstance();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['desbloquear']) && !empty($_POST['usuarios'])) {
            foreach ($_POST['usuarios'] as $email) {
                $objUsuario->setBloqueo(0);
                $objUsuario->ActualizarBloqueoUsuario($email);
            }
        }
        header('Location: /admin/bloqueados');
    }
}
?>