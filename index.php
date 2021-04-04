<?php

require_once 'vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\PersonController;
use App\Repositories\Persons\MysqlPersonsRepository;
use App\Repositories\Persons\PersonsRepository;
use App\Services\Persons\PersonService;


$container = new League\Container\Container;

$container->add(PersonsRepository::class, MysqlPersonsRepository::class);
$container->add(PersonService::class, PersonService::class)->addArgument(PersonsRepository::class);
$container->add(PersonController::class, PersonController::class)->addArgument(PersonService::class);
$container->add(HomeController::class, HomeController::class);

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', [HomeController::class, 'index']);
    $r->addRoute('GET', '/search', [HomeController::class, 'searchForm']);
    $r->addRoute('GET', '/register', [HomeController::class, 'registrationForm']);
    $r->addRoute('POST', '/register/personInfo', [PersonController::class, 'register']);
    $r->addRoute('POST', '/search/personInfo', [PersonController::class, 'search']);
    $r->addRoute('GET', '/personInfo/update', [PersonController::class, 'updateForm']);
    $r->addRoute('GET', '/personInfo/delete', [PersonController::class, 'delete']);
    $r->addRoute('POST', '/search/personInfo/updateInfo', [PersonController::class, 'update']);
});


$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        [$controller, $method] = $handler;
        echo ($container->get($controller))->$method($vars);
        break;
}