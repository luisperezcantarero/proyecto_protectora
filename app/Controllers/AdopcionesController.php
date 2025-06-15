<?php
namespace App\Controllers;
use App\Models\Adopciones;
use App\Models\Mascotas;
use App\Models\Usuario;
use App\Models\Encuestas;

class AdopcionesController extends BaseController {
    public function asignarAdoptanteAction($request) {
        $procesarFormulario = true;
        $data['error'] = $data['success'] = $data['email'] = $data['mascotaNombre'] = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['email'] = trim($_POST['adoptante_email']);
            $data['mascotaNombre'] = trim($_POST['mascota_nombre']);

            // Validación de campos vacíos
            if (empty($data['email']) || empty($data['mascotaNombre'])) {
                $procesarFormulario = false;
                $data['error'] = 'Por favor, complete todos los campos.';
            }

            // Validar adoptante
            if ($procesarFormulario) {
                $usuario = Usuario::getInstance();
                $adoptante_id = $usuario->getAdoptanteIdByEmail($data['email']);
                if (!$adoptante_id) {
                    $procesarFormulario = false;
                    $data['error'] = 'El adoptante no existe o no es adoptante.';
                }
            }

            // Validar mascota
            if ($procesarFormulario) {
                $mascota = Mascotas::getInstance();
                $mascota_id = $mascota->getMascotaIdByNombre($data['mascotaNombre']);
                if (!$mascota_id) {
                    $procesarFormulario = false;
                    $data['error'] = 'La mascota no existe o no está registrada.';
                }
            }

            // Validar que la mascota no esté ya adoptada
            if ($procesarFormulario) {
                $adopcion = Adopciones::getInstance();
                if ($adopcion->mascotaAdoptadaAlready($mascota_id)) {
                    $procesarFormulario = false;
                    $data['error'] = 'La mascota ya ha sido adoptada.';
                }
            }

            // Si todo es correcto, crear la adopción
            if ($procesarFormulario) {
                $adopcion->setMascotaId($mascota_id);
                $adopcion->setAdoptanteId($adoptante_id);
                $adopcion->setTrabajadorId($_SESSION['id']);
                $adopcion->setFechaAdopcion(date('Y-m-d H:i:s'));
                $adopcion->setEstadoId(1); // Estado en curso
                $adopcion->setCreatedAt(date('Y-m-d H:i:s'));
                $adopcion->setUpdatedAt(date('Y-m-d H:i:s'));
                $adopcion->set();
                $data['success'] = 'Adopción asignada correctamente.';
                $data['email'] = '';
                $data['mascotaNombre'] = '';
            }
        }
        $this->renderHTML('../app/views/asignar_adopcion_view.php', $data);
    }

    public function mostrarAdopcionesAction($request) {
        $adopcion = Adopciones::getInstance();
        $encuesta = Encuestas::getInstance();
        $usuarioModel = Usuario::getInstance();
        $mascotaModel = Mascotas::getInstance();

        // Actualizar el estado de las adopciones que tienen más de 15 días
        $adopcion->actualizarAdopcionesDiaLimite($_SESSION['id']);

        $data['adopciones'] = $adopcion->getAdopcionesEnCursoByAdoptante($_SESSION['id']);
        $data['adopciones_finalizadas'] = $adopcion->getAdopcionesFinalizadasByAdoptante($_SESSION['id']);
        $data['adopciones_canceladas'] = $adopcion->getAdopcionesCanceladasByAdoptante($_SESSION['id']);

        // Prepara los nombres de adoptante y trabajador para cada adopción
        $data['adoptantes'] = [];
        $data['trabajadores'] = [];
        $data['estados'] = [];

        foreach ($adopcion->getEstadosAdopcion() as $estado) {
            $data['estados'][$estado['id']] = $estado['nombre'];
        }

        foreach (['adopciones', 'adopciones_finalizadas', 'adopciones_canceladas'] as $tipo) {
            foreach ($data[$tipo] as $adopcionTipo) {
                // Adoptante
                if (!isset($data['adoptantes'][$adopcionTipo['adoptante_id']])) {
                    $adoptante = $usuarioModel->get($adopcionTipo['adoptante_id']);
                    $data['adoptantes'][$adopcionTipo['adoptante_id']] = $adoptante['nombre'];
                }
                // Trabajador
                if (!isset($data['trabajadores'][$adopcionTipo['trabajador_id']])) {
                    $trabajador = $usuarioModel->get($adopcionTipo['trabajador_id']);
                    $data['trabajadores'][$adopcionTipo['trabajador_id']] = $trabajador['nombre'];
                }
                // Mascota
                if (!isset($data['mascotas'][$adopcionTipo['mascota_id']])) {
                    $mascota = $mascotaModel->getMascota($adopcionTipo['mascota_id']);
                    $data['mascotas'][$adopcionTipo['mascota_id']] = $mascota['nombre'];
                }
            }
        }

        // Añade el campo 'tiene_encuesta' a las finalizadas
        foreach ($data['adopciones_finalizadas'] as $key => $adopcionFinalizada) {
            $data['adopciones_finalizadas'][$key]['tiene_encuesta'] = $encuesta->getEncuestaExistente($adopcionFinalizada['id']);
        }

        $data['mensaje'] = 'Estas son tus adopciones:';
        $this->renderHTML('../app/views/mostrar_adopciones_view.php', $data);
    }

    public function cancelarAdopcionAction($request) {
        $procesarFormulario = true;
        $data['error'] = $data['motivo_cancelacion'] = '';
        $data['fecha_adopcion'] = '';
        $adopcion_id = '';

        $adopcion = Adopciones::getInstance();

        // Obtener el ID de la adopción desde POST o GET
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adopcion_id = $_POST['adopcion_id'] ?? '';
        } else {
            $adopcion_id = $_GET['id'] ?? '';
        }

        // Comprobar que la adopcion pertenece al usuario
        if (!$adopcion->adopcionPerteneceAUsuario($adopcion_id, $_SESSION['id'])) {
            header('Location: /');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['motivo_cancelacion'] = trim($_POST['motivo_cancelacion']);

            // Validación de campo vacío
            if (empty($data['motivo_cancelacion'])) {
                $procesarFormulario = false;
                $data['error'] = 'Por favor, ingrese un motivo para la cancelación.';
            }

            if ($procesarFormulario) {
                $data['fecha_adopcion'] = $adopcion->getFechaAdopcionById($adopcion_id);
                // Validar que la fecha de adopción no sea mayor a 15 días
                $fecha_adopcion = strtotime($data['fecha_adopcion']);
                $fecha_actual = strtotime(date('Y-m-d H:i:s'));
                if ($fecha_actual - $fecha_adopcion > 15 * 24 * 60 * 60) { // 15 días en segundos
                    $procesarFormulario = false;
                    $data['error'] = 'No se puede cancelar una adopción que tiene más de 15 días.';
                }
            }

            $data['fecha_adopcion'] = $adopcion->getFechaAdopcionById($adopcion_id);
            // Si todo es correcto, cancelar la adopción
            if ($procesarFormulario) {
                $adopcion->cancelarAdopcion($adopcion_id, $data['motivo_cancelacion'], $_SESSION['id']);
                header('Location: /adopciones/mostrar');
            }
        } else {
            $data['fecha_adopcion'] = $adopcion->getFechaAdopcionById($adopcion_id);
        }
        $data['adopcion_id'] = $adopcion_id;
        $this->renderHTML('../app/views/cancelar_adopcion_view.php', $data);
    }
}
?>