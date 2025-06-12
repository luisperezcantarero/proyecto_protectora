<?php
session_start();
$_SESSION['rol'] = $_SESSION['rol'] ?? 'guest';
require_once "../bootstrap.php";
require_once "../vendor/autoload.php";

use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\MascotasController;

$router = new Router();

$router->add([  'name' => 'register',
                'path' => '/^\/usuarios\/register$/',
                'action' => [AuthController::class, 'registerAction',
                'profile' => ['guest']
]]);

$router->add([  'name' => 'login',
                'path' => '/^\/usuarios\/login$/',
                'action' => [AuthController::class, 'loginAction',
                'profile' => ['guest']
]]);

$router->add([  'name' => 'logout',
                'path' => '/^\/usuarios\/logout$/',
                'action' => [AuthController::class, 'logoutAction',
                'profile' => ['adoptante', 'administrador', 'trabajador']
]]);

$router->add([  'name' => 'mascotas',
                'path' => '/^\/$/',
                'action' => [MascotasController::class, 'indexAction',
                'profile' => ['guest', 'adoptante', 'administrador', 'trabajador']
]]);

$router->add([  'name' => 'mascotas_add',
                'path' => '/^\/mascotas\/add$/',
                'action' => [MascotasController::class, 'addMascotaAction'],
                'profile' => ['administrador']
]);

$router->add([  'name' => 'mascotas_edit',
                'path' => '/^\/mascotas\/edit\/?$/',
                'action' => [MascotasController::class, 'editMascotaAction'],
                'profile' => ['administrador']
]);

$router->add([  'name' => 'mascotas_delete',
                'path' => '/^\/mascotas\/delete\/?$/',
                'action' => [MascotasController::class, 'deleteMascotaAction'],
                'profile' => ['administrador']
]);

$router->add([  'name' => 'mascotas_search',
                'path' => '/^\/mascotas\/filter\/?$/',
                'action' => [MascotasController::class, 'filterMascotaAction'],
                'profile' => ['guest', 'adoptante', 'administrador', 'trabajador']
]);

$router->add([  'name' => 'Verificar la cuenta',
                'path' => '/^\/verificacion(\/|\?token=)[\w\|.\+\-\/=]+$/',
                'action' => [AuthController::class, 'verifyAction']
]);

$request = explode('?', $_SERVER['REQUEST_URI'])[0];
$route = $router->match($request);

if($route){
    // Comprobar si el usuario está autenticado y si la ruta requiere un perfil específico
    if (isset($route['profile']) && !in_array($_SESSION['rol'], $route['profile'])) {
        header('Location: /');
    } else {
        $controllerName = $route['action'][0];
        $actionName = $route['action'][1];
        $controller = new $controllerName;
        $controller->$actionName($request);
    }
}else{
    echo "No route";
}
?>
