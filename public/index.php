<?php
//PHP nos regrese todo error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';
//include_once '../config.php';



$baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . $baseDir;

define('BASEURL', $baseUrl);

$dotenv = new \Dotenv\Dotenv(__DIR__ . '/..');
$dotenv -> load();
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => getenv('DB_HOST'),
    'database'  => getenv('DB_NAME'),
    'username'  => getenv('DB_USER'),
    'password'  => getenv('DB_PASS'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$route = $_GET['route'] ?? '/';
/*
function render($filename, $params){
	ob_start();//Almacen interno
	extract($params);//Extraer un arreglo asociativo
	include $filename;
	return ob_get_clean();//Trae datos del buffer y los limpia
}
*/
use Phroute\Phroute\RouteCollector;


$router = new RouteCollector();

$router -> filter('auth', function () {
	if(!isset($_SESSION['userId'])){
		header('location:' . BASEURL . 'auth/login');
		return false;
	}
});

$router -> group(['before' => 'auth'], function ($router){
	$router -> controller('/admin', App\Controllers\Admin\IndexController::class);

	$router -> controller('/admin/posts', App\Controllers\Admin\PostController::class);
	
	$router -> controller('/admin/users', App\Controllers\Admin\UserController::class);
});

$router -> controller('/', App\Controllers\IndexController::class);

$router -> controller('/auth', App\Controllers\AuthController::class);


/*
$router -> controller('/admin/posts/create', App\Controllers\Admin\IndexController::class);
$router -> controller('/admin/posts/create', App\Controllers\Admin\IndexController::class);
*/
$dispatcher = new Phroute\Phroute\Dispatcher($router -> getData());
$response=$dispatcher -> dispatch($_SERVER['REQUEST_METHOD'], $route);

echo $response;
/*
$route = $_GET['route'] ?? '/';
switch ($route) {
	case '/':
	  require '../index.php';
		break;
	case '/admin':
	  require '../admin/index.php';
		break;
	case '/admin/posts':
	  require '../admin/posts.php';
		break;	
	default:
	  require '../index.php';
		break;
}
*/