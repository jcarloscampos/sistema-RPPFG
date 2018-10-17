<?php

/**
 * Aplicando el patrón de diseño FRONT CONTROLLER
 * Con el objetivo de tener un solo punto de entrada, esta será un controlador que reciba
 * todas las peticione de la aplicación y se debe hacer cargo de todo el flujo común de las paginas
 */

//Se agrega el módulo de auto carga para usar la clase phroute
require_once '../vendor/autoload.php';

/*Constante que nos permite obtener la base URL en todo el proyecto, que será la raíz en la que esta proyecto*/
$baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . $baseDir;
define('BASE_URL', $baseUrl);


use Illuminate\Database\Capsule\Manager as Capsule;

//crea una nueva instancia de administrador Capsule
//Capsule tiene como objetivo hacer una configuración de esta biblioteca para su uso fuera del marco de Laravel
$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'sistema-rppfg',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

//Hacer que esta instancia de Capsule esté disponible globalmente a través de métodos estáticos
$capsule->setAsGlobal();

//Configurar el ORM elocuente ... (opcional; a menos que haya usado setEventDispatcher ())
$capsule->bootEloquent();

//Verifica si hay alguna entrada en la barra de navegacion a parte del URL_BASE
$route = (isset($_GET['route'])) ? $_GET['route'].'/' : '/';

/* Phroute es un ruteador muy velos e independiente, se puede usar en cualquier proyecto sin tener un frameword completo de php
* Las rutas de definen usando RouteCollector
* Las rutas se crean conociendo el tipo de request (get, pot, etc.) que se va a tener
*/
use Phroute\Phroute\RouteCollector;

$router = new RouteCollector();

//rutas
// $router->controller('/student', AppPHP\Controllers\Student\IndexController::class);
// $router->controller('/student/registry', AppPHP\Controllers\Student\RegistryController::class);
$router->controller('/admin', AppPHP\Controllers\Admin\IndexController::class);
$router->controller('/admin/area', AppPHP\Controllers\Admin\AddareaController::class);
$router->controller('/admin/subarea', AppPHP\Controllers\Admin\AddsubareaController::class);

$router->controller('/admin/teachers', AppPHP\Controllers\Admin\TeachersController::class);
//$router->controller('/admin/importproject', AppPHP\Controllers\Admin\ImportprojectController::class);

$router->controller('/', AppPHP\Controllers\IndexController::class);

/*El Dispatcher, es el objeto que va a tomar la ruta que nos llega y manda a llamar la función que realmente se necesita
Luego generamos una respuesta que será lo que nos regresa el Dispatcher*/
$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

/*En REQUEST_METHOD se obtiene la palabra get o post según el métodos que se usa para mandar a llamar la pagina*/
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $route);
echo $response;
