<?php
namespace App\Controllers;
use App\Models\Mascotas;

class MascotasController extends BaseController {
    public function indexAction($request) {
        $modeloMascota = Mascotas::getInstance();
        $data['mascotas'] = $modeloMascota->getAllMascotas();
        $data['mensaje'] = 'Listado de Mascotas: ';
        $this->renderHTML('../app/views/index_view.php', $data);
    }

    // Action to add a new pet
    public function addMascotaAction($request) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $modeloMascota = Mascotas::getInstance();
            $modeloMascota->setNombre($_POST['nombre']);
            $modeloMascota->setTipoAnimal($_POST['tipoAnimal']);
            $modeloMascota->setRaza($_POST['raza']);
            $modeloMascota->setEdad($_POST['edad']);
            // Permitimos que el propietario sea nulo
            $propietario_id = !empty($_POST['propietario_id']) ? $_POST['propietario_id'] : null;
            $modeloMascota->setPropietarioId($propietario_id);
            $modeloMascota->set();

            header('Location: /');
        } else {
            $this->renderHTML('../app/views/add_view.php');
        }
    }

    public function editMascotaAction($request) {
        // Verificamos si se ha pasado un ID de mascota
        if (isset($_GET['id'])) {
            $modeloMascota = Mascotas::getInstance();
            $modeloMascota->setId($_GET['id']);
            $mascota = $modeloMascota->getMascota();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $modeloMascota->setNombre($_POST['nombre']);
                $modeloMascota->setTipoAnimal($_POST['tipoAnimal']);
                $modeloMascota->setRaza($_POST['raza']);
                $modeloMascota->setEdad($_POST['edad']);
                // Permitimos que el propietario sea nulo
                $propietario_id = !empty($_POST['propietario_id']) ? $_POST['propietario_id'] : null;
                $modeloMascota->setPropietarioId($propietario_id);
                $modeloMascota->edit();
                header('Location: /');
            }
            $data['mascota'] = $mascota;
            $this->renderHTML('../app/views/edit_view.php', $data);
        } else {
            // Si no se encuentra la mascota, redirigimos al listado
            header('Location: /');
        }
    }

    public function deleteMascotaAction($request) {
        if (isset($_GET['id'])) {
            $modeloMascota = Mascotas::getInstance();
            // Pasamos el ID de la mascota a eliminar
            $modeloMascota->delete($_GET['id']);
            header('Location: /');
        } else {
            // Si no se pasa un ID, redirigimos al listado
            header('Location: /');
        }
    }

    public function filterMascotaAction($request) {
        if (isset($_GET['filter'])) {
            $modeloMascota = Mascotas::getInstance();
            $data['mascotas'] = $modeloMascota->getFilterMascotas($_GET['filter']);
            $data['mensaje'] = 'Mascotas filtradas: ';
            $this->renderHTML('../app/views/index_view.php', $data);
        } else {
            // Si no se pasa un filtro, redirigimos al listado completo
            header('Location: /');
        }
    }
}
?>