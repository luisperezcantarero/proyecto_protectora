<?php
namespace App\Controllers;
use App\Models\Propietario;
use App\Models\Mascotas;

class PropietarioController extends BaseController {
    public function indexAction() {
        $data['location'] = 'propietarios';
        $data['mensaje'] = 'Listado de propietarios';
        $this->renderHTML('../app/views/propietarios_view.php', $data);
    }

    public function addPropietarioAction($request) {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario_id = $_SESSION['usuario_id'];
            // Puedes obtener el nombre del usuario desde la sesión o la base de datos
            $nombre = $_SESSION['user'] ?? '';
            $modeloPropietario = Propietario::getInstance();
            $resultado = $modeloPropietario->setPropietario($usuario_id, $nombre);
            if ($resultado) {
                $_SESSION['mensaje'] = 'Propietario creado correctamente.';
            } else {
                $_SESSION['mensaje'] = $modeloPropietario->getMessage();
            }
            header('Location: /propietarios');
        } else {
            header('Location: /propietarios');
        }
    }
}
?>