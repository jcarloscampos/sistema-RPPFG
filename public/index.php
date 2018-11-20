<?php

/**
 * Aplicando el patrón de diseño FRONT CONTROLLER
 * Con el objetivo de tener un solo punto de entrada, esta será un controlador que reciba
 * todas las peticione de la aplicación y se debe hacer cargo de todo el flujo común de las paginas
 */

//Se agrega el módulo de auto carga para usar la clase phroute
require_once '../vendor/autoload.php';
session_start();

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
    'database'  => 'sistema',
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
$router->filter('adm', function(){
    if(!isset($_SESSION['admID'])){
        header('Location: ' . BASE_URL . '');
        return false;
    }
});

$router->filter('pst', function(){
    if(!isset($_SESSION['postID'])){
        header('Location: ' . BASE_URL . '');
        return false;
    }
});

$router->filter('prof', function(){
    if(!isset($_SESSION['profID'])){
        header('Location: ' . BASE_URL . '');
        return false;
    }   
});

//rutas
$router->controller('/', AppPHP\Controllers\IndexController::class);

$router->controller('/admin', AppPHP\Controllers\Admin\IndexController::class);
$router->group(['before' => 'adm'], function($router){
    $router->controller('/admin/area', AppPHP\Controllers\Admin\AreaController::class);
    $router->controller('/admin/config', AppPHP\Controllers\Admin\ConfigController::class);
    $router->controller('/admin/professionals', AppPHP\Controllers\Admin\ProfessionalsController::class);
    $router->controller('/admin/postulants', AppPHP\Controllers\Admin\PostulantsController::class);
    $router->controller('/admin/projects', AppPHP\Controllers\Admin\ProjectsController::class);
    $router->controller('/admin/users', AppPHP\Controllers\Admin\UsersController::class);
});

$router->controller('/secretary', AppPHP\Controllers\Secretary\IndexController::class);
$router->group(['before' => 'sct'], function($router){
    $router->controller('/secretary/config', AppPHP\Controllers\secretary\configController::class);
    $router->controller('/secretary/settle', AppPHP\Controllers\secretary\SettleController::class);
});


$router->controller('/postulant', AppPHP\Controllers\Postulant\IndexController::class);
$router->group(['before' => 'pst'], function($router){
    $router->controller('/postulant/config', AppPHP\Controllers\Postulant\ConfigController::class);
    $router->controller('/postulant/actualize', AppPHP\Controllers\Postulant\ActualizeProfileController::class);
    $router->controller('/postulant/settle', AppPHP\Controllers\Postulant\SettleController::class);
    $router->controller('/postulant/settle/heading', AppPHP\Controllers\Postulant\Defprofile\HeadingController::class);
    $router->controller('/postulant/settle/essence', AppPHP\Controllers\Postulant\Defprofile\EssenceController::class);
    $router->controller('/postulant/settle/restrained', AppPHP\Controllers\Postulant\Defprofile\RestrainedController::class);

});


// $router->controller('/professional', AppPHP\Controllers\Professional\IndexController::class);
// $router->group(['before' => 'prof'], function($router){
//     $router->controller('/professional/itnConfig', AppPHP\Controllers\Professional\ItnConfigController::class);
//     $router->controller('/professional/etnConfig', AppPHP\Controllers\Professional\EtnConfigController::class);
// });

$router->controller('/itnprofessional', AppPHP\Controllers\Professional\ItnController::class);
$router->controller('/etnprofessional', AppPHP\Controllers\Professional\EtnController::class);
// $router->group(['before' => 'prof'], function($router){
//     $router->controller('/professional/itnConfig', AppPHP\Controllers\Professional\ItnConfigController::class);
//     $router->controller('/professional/etnConfig', AppPHP\Controllers\Professional\EtnConfigController::class);
// });



$router->controller('/director', AppPHP\Controllers\Director\IndexController::class);

$router->controller('/signup', AppPHP\Controllers\Accounts\SignupController::class);
$router->controller('/signin', AppPHP\Controllers\Accounts\SigninController::class);
$router->controller('/logout', AppPHP\Controllers\Accounts\LogoutController::class);
$router->controller('/forgotpass', AppPHP\Controllers\Accounts\ForgotPassController::class);





/*El Dispatcher, es el objeto que va a tomar la ruta que nos llega y manda a llamar la función que realmente se necesita
Luego generamos una respuesta que será lo que nos regresa el Dispatcher*/
$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

/*En REQUEST_METHOD se obtiene la palabra get o post según el métodos que se usa para mandar a llamar la pagina*/
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $route);
echo $response;
