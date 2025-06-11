<?php
session_start();
$_SESSION['user_profile'] = $_SESSION['user_profile'] ?? 'guest';
require_once "../bootstrap.php";
require_once "../vendor/autoload.php";

use App\Core\Router;
use App\Controllers\DefaultController;
use App\Controllers\AuthController;
use App\Controllers\MascotasController;
use App\Controllers\PropietarioController;

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
                'profile' => ['user', 'admin']
]]);

$router->add([  'name' => 'mascotas',
                'path' => '/^\/$/',
                'action' => [MascotasController::class, 'indexAction',
                'profile' => ['guest']
]]);

$router->add([  'name' => 'mascotas_add',
                'path' => '/^\/mascotas\/add$/',
                'action' => [MascotasController::class, 'addMascotaAction'],
                'profile' => ['admin']
]);

$router->add([  'name' => 'mascotas_edit',
                'path' => '/^\/mascotas\/edit\/?$/',
                'action' => [MascotasController::class, 'editMascotaAction'],
                'profile' => ['admin']
]);

$router->add([  'name' => 'mascotas_delete',
                'path' => '/^\/mascotas\/delete\/?$/',
                'action' => [MascotasController::class, 'deleteMascotaAction'],
                'profile' => ['admin']
]);

$router->add([  'name' => 'mascotas_search',
                'path' => '/^\/mascotas\/filter\/?$/',
                'action' => [MascotasController::class, 'filterMascotaAction'],
                'profile' => ['guest', 'user', 'admin']
]);

$router->add([  'name' => 'propietarios',
                'path' => '/^\/propietarios$/',
                'action' => [PropietarioController::class, 'indexAction'],
                'profile' => ['guest', 'user', 'admin']
]);

$router->add([  'name' => 'propietarios_add',
                'path' => '/^\/propietarios\/add$/',
                'action' => [PropietarioController::class, 'addPropietarioAction'],
                'profile' => ['user', 'admin']
]);

$router->add([  'name' => 'Verificar la cuenta',
                'path' => '/^\/verificacion(\/|\?token=)[\w\|.\+\-\/=]+$/',
                'action' => [AuthController::class, 'verifyAction']
]);

$request = explode('?', $_SERVER['REQUEST_URI'])[0];
$route = $router->match($request);

if($route){
    // Comprobar si el usuario está autenticado y si la ruta requiere un perfil específico
    if (isset($route['profile']) && !in_array($_SESSION['user_profile'], $route['profile'])) {
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
