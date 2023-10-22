<?php
require __DIR__ . '/vendor/autoload.php';

use ContactsApi\Container\Container;
use ContactsApi\Controllers\CompanyController;
use ContactsApi\Controllers\ContactController;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;

$container = new Container();
$container->set(ContactController::class, function (Container $container) {
  return new ContactController($container->get(\PDO::class));
});

$container->set(CompanyController::class, function (Container $container) {
  return new CompanyController($container->get(\PDO::class));
});

$container->set(\PDO::class, function () {
  $pdo = new \PDO('mysql:host=localhost;port=3306;dbname=enterprise', 'root', 'user123');
  $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  return $pdo;
});

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

$app->addErrorMiddleware(true, true, true);

$app->get('/contacts', [ContactController::class, 'findAllOrFilterByParam']);
$app->post('/contacts', [ContactController::class, 'create']);
$app->put('/contacts/{id}', [ContactController::class,'update']);
$app->delete('/contacts/{id}', [ContactController::class, 'delete']);

$app->get('/company', [CompanyController::class, 'findAll']);
$app->post('/company', [CompanyController::class, 'create']);
$app->put('/company/{id}', [CompanyController::class, 'update']);
$app->delete('/company/{id}', [CompanyController::class, 'delete']);

$app->options('/{routes:.+}', function ($request, $response) {
  return $response;
});

$app->add(function (ServerRequestInterface $request, RequestHandlerInterface $requestHandler) {
  $response = $requestHandler->handle($request);
  return $response
              ->withHeader('Access-Control-Allow-Origin', '*')
              ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
              ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->run();
