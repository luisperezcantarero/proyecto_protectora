<?php
session_start();
$_SESSION['user_profile'] = $_SESSION['user_profile'] ?? 'guest';
require_once "../bootstrap.php";
require_once "../vendor/autoload.php";

use App\Core\Router;
use App\Controllers\DefaultController;
use App\Controllers\AuthController;

$router = new Router();

$router->add([  'name' => 'index',
                'path' => '/^\/$/',
                'action' => [DefaultController::class, 'IndexAction'
]]);

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

$request = $_SERVER['REQUEST_URI'];
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
