<?php

namespace ContactsApi\Controllers;

use ContactsApi\Models\CompanyModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ContactsApi\Services\CompanyService;

class CompanyController {

  private CompanyService $companyService;

  public function __construct() { 
    $this->companyService = new CompanyService();
  }

  public function findAll(ServerRequestInterface $request, ResponseInterface $response) {
    try {
      $companies = $this->companyService->findAll();

      $response->getBody()->write(json_encode($companies));
      return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
    }catch (\Exception $e) {
      throw new \Exception("Nenhuma empresa encontrada!");
    }
  }

  public function create(ServerRequestInterface $request, ResponseInterface $response) {
    $data = (object) $request->getParsedBody();

    $company = new CompanyModel();
    $company->setName($data->name);

    try {
      $companySaved = $this->companyService->save($company);

      $response->getBody()->write(json_encode($companySaved->jsonSerialize()));
      return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);
    }catch (\Exception $e) {
      throw new \Exception("Falha ao cadastrar empresa!");
    }
  }

  public function update(ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $data = (object) $request->getParsedBody();
    $id = intval($args['id']);

    $company = new CompanyModel();
    $company->setName($data->name);

    try {
      $updatedCompany = $this->companyService->update($company, $id);

      $response->getBody()->write(json_encode($updatedCompany->jsonSerialize()));
      return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
    }catch (\Exception $e) {
      throw new \Exception("Falha ao atualizar empresa!");
    }
  }

  public function delete(ServerRequestInterface $request, ResponseInterface $response, array $args) { 
    $id = intval($args['id']);
    
    try {
      $this->companyService->delete($id);

      $response->getBody()->write(json_encode('Empresa deletada com sucesso!'));
      return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
    }catch (\Exception $e) {
      throw new \Exception('Erro ao Deletar empresa!');
    }
  }
}
