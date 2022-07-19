<?php

require __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

$path = $_SERVER['PATH_INFO'];
$routes = require __DIR__ . '/../Config/routes.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

if (!array_key_exists($path, $routes[$requestMethod])) {
    http_response_code(404);
    exit();
}

$creator = new ServerRequest(
    'get|post', // method
    'localhost', // uri
);

$controllerClass = $routes[$requestMethod][$path];

/** @var ContainerInterface $container */
$container = require __DIR__ . '/../Config/dependencies.php';

/** @var RequestHandlerInterface $controller */
$controller = $container->get($controllerClass);

$serverRequest = $creator->fromGlobals();
$response = $controller->handle($serverRequest);

foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

http_response_code($response->getStatusCode());
echo $response->getBody();