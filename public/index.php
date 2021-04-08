<?php

require_once '../vendor/autoload.php';


use App\Controllers\HomeController;
use App\Controllers\PersonController;
use App\Repositories\Persons\MysqlPersonsRepository;
use App\Repositories\Persons\PersonsRepository;
use App\Services\Persons\PersonService;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$container = new League\Container\Container;
$container->add('loader', FilesystemLoader::class )->addArgument('/mnt/c/projects/person-registry/app/Views/');
$container->add('twig', Environment::class)->addArgument('loader');
$container->add(PersonsRepository::class, MysqlPersonsRepository::class);
$container->add(PersonService::class, PersonService::class)->addArgument(PersonsRepository::class);
$container->add(PersonController::class, PersonController::class)->addArguments([PersonService::class, 'twig']);
$container->add(HomeController::class, HomeController::class)->addArgument('twig');

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', [HomeController::class, 'index']);
    $r->addRoute('GET', '/search', [HomeController::class, 'searchForm']);
    $r->addRoute('GET', '/register', [HomeController::class, 'registrationForm']);
    $r->addRoute('POST', '/register/personInfo', [PersonController::class, 'register']);
    $r->addRoute('POST', '/search/personInfo', [PersonController::class, 'search']);
    $r->addRoute('POST', '/personInfo/update', [PersonController::class, 'updateForm']);
    $r->addRoute('POST', '/personInfo/delete', [PersonController::class, 'delete']);
    $r->addRoute('POST', '/search/personInfo/updateInfo', [PersonController::class, 'update']);
    $r->addRoute('GET', '/authorize', [PersonController::class, 'authorize']);
    $r->addRoute('POST', '/authorize/check', [PersonController::class, 'checkAuthorization']);
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