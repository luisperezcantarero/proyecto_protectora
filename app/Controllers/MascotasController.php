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
            $modeloMascota->setEspecie($_POST['especie']);
            $modeloMascota->setRaza($_POST['raza']);
            $modeloMascota->setEdad($_POST['edad']);
            $modeloMascota->setEstado(1); // Estado de en adopción
            $modeloMascota->setHistorial($_POST['historial_medico']);
            $modeloMascota->setFoto($_POST['foto']);
            $modeloMascota->setFechaIngreso(date('Y-m-d H:i:s'));
            $modeloMascota->setCreadoPor($_SESSION['id']); // Asignamos el ID del usuario que crea la mascota
            $modeloMascota->setCreatedAt(date('Y-m-d H:i:s'));
            $modeloMascota->setUpdatedAt(date('Y-m-d H:i:s'));
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
            $id = $_GET['id'];
            $mascota = $modeloMascota->getMascota($id);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $modeloMascota->setId($id);
                $modeloMascota->setNombre($_POST['nombre']);
                $modeloMascota->setEspecie($_POST['especie']);
                $modeloMascota->setRaza($_POST['raza']);
                $modeloMascota->setEdad($_POST['edad']);
                $modeloMascota->setEstado(1); // Mantenemos el estado en adopción
                $modeloMascota->setHistorial($_POST['historial_medico']);
                $modeloMascota->setFoto($_POST['foto']);
                $modeloMascota->setUpdatedAt(date('Y-m-d H:i:s'));
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