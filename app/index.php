<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/database/Database.php';

use ContactsApi\Container\Container;
use ContactsApi\Controllers\CompanyController;
use ContactsApi\Controllers\ContactController;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;

$container = new Container();
$container->set(ContactController::class, function () {
  return new ContactController();
});
$container->set(CompanyController::class, function () {
  return new CompanyController();
});

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

$app->addErrorMiddleware(true, true, true);

$app->get('/app/contacts', [ContactController::class, 'findAllOrFilterByParam']);
$app->post('/app/contacts', [ContactController::class, 'create']);
$app->put('/app/contacts/{id}', [ContactController::class,'update']);
$app->delete('/app/contacts/{id}', [ContactController::class, 'delete']);

$app->get('/app/companies', [CompanyController::class, 'findAll']);
$app->post('/app/companies', [CompanyController::class, 'create']);
$app->put('/app/companies/{id}', [CompanyController::class, 'update']);
$app->delete('/app/companies/{id}', [CompanyController::class, 'delete']);

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
