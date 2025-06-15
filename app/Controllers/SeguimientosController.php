<?php
namespace App\Controllers;
use App\Models\Seguimientos;
use App\Models\Adopciones;

class SeguimientosController extends BaseController {
    public function listarAllAdopciones($request) {
        $adopcionesModel = Adopciones::getInstance();
        $seguimientosModel = Seguimientos::getInstance();
        $data['adopciones'] = $adopcionesModel->getAllAdopciones();

        $data['observaciones'] = [];
        foreach ($data['adopciones'] as $adopcion) {
            $data['observaciones'][$adopcion['id']] = $seguimientosModel->getObservacionesPorAdopcion($adopcion['id']);
        }
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