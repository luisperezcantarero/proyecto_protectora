<?php
namespace App\Controllers;
use App\Models\Seguimientos;
use App\Models\Adopciones;
use App\Models\Usuario;
use App\Models\Roles;
use App\Models\Mascotas;

class SeguimientosController extends BaseController {
    public function listarAllAdopciones($request) {
        $adopcionesModel = Adopciones::getInstance();
        $seguimientosModel = Seguimientos::getInstance();
        $usuariosModel = Usuario::getInstance();
        $mascotasModel = Mascotas::getInstance();

        $adopciones = $adopcionesModel->getAllAdopciones();
        $data['observaciones'] = [];
        $data['mascotas'] = [];
        $data['trabajadores'] = [];
        $data['canceladores'] = [];
        $data['estados'] = [];
        $data['adoptantes'] = [];

        // Obtener los nombre de los estados de adopción
        foreach ($adopcionesModel->getEstadosAdopcion() as $estado) {
            $data['estados'][$estado['id']] = $estado['nombre'];
        }

        $adopcionesProcesadas = [];
        foreach ($adopciones as $adopcion) {
            // Obtener las observaciones de seguimiento
            $data['observaciones'][$adopcion['id']] = $seguimientosModel->getObservacionesPorAdopcion($adopcion['id']);
            // Obtener mascota
            $mascota = $mascotasModel->getMascota($adopcion['mascota_id']);
            $data['mascotas'][$adopcion['mascota_id']] = $mascota['nombre'];
            // Obtener trabajador
            $trabajador = $usuariosModel->get($adopcion['trabajador_id']);
            $data['trabajadores'][$adopcion['trabajador_id']] = $trabajador['nombre'];
            // Obtener adoptante
            $adoptante = $usuariosModel->get($adopcion['adoptante_id']);
            $data['adoptantes'][$adopcion['adoptante_id']] = $adoptante['nombre'];
            // Obtener adoptante que ha cancelado la adopción
            if (!empty($adopcion['cancelada_por_id'])) {
                $cancelador = $usuariosModel->get($adopcion['cancelada_por_id']);
                $data['canceladores'][$adopcion['cancelada_por_id']] = $cancelador ? $cancelador['nombre'] : '';
            } else {
                $data['canceladores'][$adopcion['cancelada_por_id']] = '';
            }

            // Mostrar datos de cancelación solo si el estado es "cancelada"
            if ($adopcion['estado_id'] == 2) {
                $adopcion['mostrar_cancelacion'] = true;
            } else {
                $adopcion['mostrar_cancelacion'] = false;
                $adopcion['fecha_cancelacion'] = '';
                $adopcion['cancelada_por_id'] = '';
                $adopcion['motivo_cancelacion'] = '';
            }

            $adopcionesProcesadas[] = $adopcion;
        }

        $data['adopciones'] = $adopcionesProcesadas;

        $this->renderHTML('../app/views/historial_listar_view.php', $data);
    }

    public function addObservacionesAction($request) {
        // Solo los trabajadores y administradores pueden añadir observaciones
        if (!in_array($_SESSION['rol'], ['trabajador', 'administrador'])) {
            header('Location: /');
        }

        $adopcion_id = $_GET['adopcion_id'];
        if (!$adopcion_id) {
            header('Location: /seguimientos/listar');
        }

        $seguimientosModel = Seguimientos::getInstance();
        $adopciones = Adopciones::getInstance();
        $adopcion = $adopciones->get($adopcion_id);
        if (!in_array($adopcion['estado_id'], [2, 3])) {
            header('Location: /seguimientos/listar');
        }

        if ($seguimientosModel->existeObservacion($adopcion_id)) {
            header('Location: /seguimientos/listar');
        }

        $data['error'] = '';
        $procesaFormulario = true;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $_POST['resultado'];
            $observaciones = $_POST['observaciones'];
            $tipo_id = $_POST['tipo_id'];
            $fecha = date('Y-m-d H:i:s');

            if (!$resultado || !$observaciones || !$tipo_id) {
                $data['error'] = 'Por favor, complete todos los campos obligatorios.';
                $procesaFormulario = false;
            }

            if ($procesaFormulario) {
                $fecha = date('Y-m-d H:i:s');
                $seguimientosModel->setAdopcionId($adopcion_id);
                $seguimientosModel->setTrabajadorId($_SESSION['id']);
                $seguimientosModel->setFecha($fecha);
                $seguimientosModel->setTipoId($tipo_id);
                $seguimientosModel->setResultado($resultado);
                $seguimientosModel->setObservaciones($observaciones);
                $seguimientosModel->setCreatedAt($fecha);
                $seguimientosModel->setUpdatedAt($fecha);
                $seguimientosModel->set();
                header('Location: /seguimientos/listar');
            }
        }
        $data['adopcion'] = $adopcion;
        $data['tipos_seguimiento'] = $seguimientosModel->getTiposSeguimiento();
        $this->renderHTML('../app/views/historial_add_view.php', $data);
    }
}
?>