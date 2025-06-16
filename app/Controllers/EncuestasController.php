<?php
namespace App\Controllers;
use App\Models\Encuestas;
use App\Models\Adopciones;
use App\Models\Mascotas;

class EncuestasController extends BaseController {
    public function encuestaAction($request) {
        $adopcion_id = $_GET['id'];
        $adopcion = Adopciones::getInstance();
        $encuesta = Encuestas::getInstance();

        if (!$adopcion->adopcionPerteneceAUsuario($adopcion_id, $_SESSION['id'])) {
            header('Location: /');
        }
        $adopcion_data = $adopcion->get($adopcion_id);
        if ($adopcion_data['estado_id'] != 3) {
            header('Location: /adopciones/mostrar/');
        }

        $mascota_nombre = '';
        if (isset($adopcion_data['mascota_id'])) {
            $mascotaModel = Mascotas::getInstance();
            $mascota = $mascotaModel->getMascota($adopcion_data['mascota_id']);
            $mascota_nombre = $mascota['nombre'];
        }

        // Verificar si ya existe una encuesta para esta adopción
        if ($encuesta->getEncuestaExistente($adopcion_id)) {
            header('Location: /adopciones/mostrar/');
        }

        $procesaFormulario = true;
        $data['errorEncuesta'] = '';
        $data['adopcion'] = $adopcion_data;
        $data['estados_salud'] = $encuesta->getEstadosSalud();
        $data['adaptaciones'] = $encuesta->getAdaptaciones();
        $data['adopcion'] = $adopcion_data;
        $data['mascota_nombre'] = $mascota_nombre;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $estado_salud_id = $_POST['estado_salud_id'];
            $adaptacion_id = $_POST['adaptacion_id'];
            $comentarios = $_POST['comentarios'];

            if (!$estado_salud_id || !$adaptacion_id) {
                $data['errorEncuesta'] = 'Por favor, complete todos los campos obligatorios.';
                $procesaFormulario = false;
            }
            
            if ($procesaFormulario) {
                $encuesta->setAdopcionId($adopcion_id);
                $encuesta->setFechaEnvio(date('Y-m-d H:i:s'));
                $encuesta->setFechaRespuesta(date('Y-m-d H:i:s'));
                $encuesta->setEstadoSaludId($estado_salud_id);
                $encuesta->setAdaptacionId($adaptacion_id);
                $encuesta->setComentarios($comentarios);
                $encuesta->setCreatedAt(date('Y-m-d H:i:s'));
                $encuesta->setUpdatedAt(date('Y-m-d H:i:s'));
                $encuesta->set();
                header('Location: /adopciones/mostrar');
            }
        }
        $this->renderHTML('../app/views/encuesta_adopcion_view.php', $data);
    }
}
?>