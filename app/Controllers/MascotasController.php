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
        $procesaFormulario = false;
        $data = [];
        $data['nombre'] = $data['especie'] = $data['raza'] = $data['edad'] = $data['historial_medico'] = '';
        $data['foto'] = 'default.jpg';
        $data['nombreError'] = $data['especieError'] = $data['razaError'] = $data['edadError'] = $data['historial_medicoError'] = $data['fotoError'] = '';

        $imagen = false;

        if (!empty($_POST)) {
            $data['nombre'] = $_POST['nombre'];
            $data['especie'] = $_POST['especie'];
            $data['raza'] = $_POST['raza'];
            $data['edad'] = $_POST['edad'];
            $data['historial_medico'] = $_POST['historial_medico'];

            // Validación de imagen
            if (isset($_FILES['foto_mascota']) && $_FILES['foto_mascota']['error'] == 0) {
                if ($_FILES['foto_mascota']['type'] == 'image/jpeg' || $_FILES['foto_mascota']['type'] == 'image/png' || $_FILES['foto_mascota']['type'] == 'image/jpg') {
                    if ($_FILES['foto_mascota']['size'] < 2000000) {
                        $imagen = true;
                    } else {
                        $data['fotoError'] = 'La imagen es demasiado grande. Debe ser menor a 2MB.';
                    }
                } else {
                    $data['fotoError'] = 'El archivo debe ser una imagen JPEG o PNG.';
                }
            }
        }

        $procesaFormulario = true;
        // Validamos los campos obligatorios
        if (empty($data['nombre'])) {
            $procesaFormulario = false;
            $data['nombreError'] = 'El nombre de la mascota es obligatorio.';
        }
        if (empty($data['especie'])) {
            $procesaFormulario = false;
            $data['especieError'] = 'La especie de la mascota es obligatoria.';
        }
        if (empty($data['raza'])) {
            $procesaFormulario = false;
            $data['razaError'] = 'La raza de la mascota es obligatoria.';
        }
        if (empty($data['edad']) || !is_numeric($data['edad']) || $data['edad'] < 0) {
            $procesaFormulario = false;
            $data['edadError'] = 'La edad de la mascota es obligatoria y debe ser un número positivo.';
        }
        if (empty($data['historial_medico'])) {
            $procesaFormulario = false;
            $data['historial_medicoError'] = 'El historial médico de la mascota es obligatorio.';
        }

        if ($procesaFormulario) {
            if ($imagen) {
                // Subir la imagen
                $nombreImagen = $_FILES['foto_mascota']['name'];
                $extension = pathinfo($nombreImagen, PATHINFO_EXTENSION);
                $nombreUnico = uniqid() . '.' . $extension;
                move_uploaded_file($_FILES['foto_mascota']['tmp_name'], dirname(__DIR__, 2) . '/public/imagenes/' . $nombreUnico);
                $fotoMascota = $nombreUnico;
            } else {
                $fotoMascota = 'default.jpg';
            }

            $modeloMascota = Mascotas::getInstance();
            $modeloMascota->setNombre($data['nombre']);
            $modeloMascota->setEspecie($data['especie']);
            $modeloMascota->setRaza($data['raza']);
            $modeloMascota->setEdad($data['edad']);
            $modeloMascota->setEstado(1); // Estado de en adopción
            $modeloMascota->setHistorial($data['historial_medico']);
            $modeloMascota->setFoto($fotoMascota);
            $modeloMascota->setFechaIngreso(date('Y-m-d H:i:s'));
            $modeloMascota->setCreadoPor($_SESSION['id']);
            $modeloMascota->setCreatedAt(date('Y-m-d H:i:s'));
            $modeloMascota->setUpdatedAt(date('Y-m-d H:i:s'));
            $modeloMascota->set();

            header('Location: /');
        } else {
            $this->renderHTML('../app/views/add_view.php', $data);
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