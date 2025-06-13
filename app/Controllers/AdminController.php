<?php
namespace App\Controllers;
use App\Models\Usuario;

class AdminController extends BaseController {
    public function usuariosBloqueadosAction() {
        $objUsuario = Usuario::getInstance();
        $usuariosBloqueados = $objUsuario->getUsuariosBloqueados();
        $data['bloqueados'] = $usuariosBloqueados;
        $data['checked'] = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['marcar_todos'])) {
                $data['checked'] = 'checked';
            } elseif (isset($_POST['desmarcar_todos'])) {
                $data['checked'] = '';
            }
        }
        $this->renderHTML('../app/views/usuarios_bloqueados_view.php', $data);
    }

    public function desbloquearUsuariosAction() {
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