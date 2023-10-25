<?php

namespace ContactsApi\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ContactsApi\Services\ContactService;

class ContactController {

  private ContactService $contactService;

  public function __construct(
    protected \PDO $pdo
  ) { 
    $this->contactService = new ContactService($pdo);
  }

  public function findAllOrFilterByParam(ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $params = $request->getQueryParams();
    
    try {
      $contacts = $this->contactService->findAllOrFilterByParam($params);
   
      $response->getBody()->write(json_encode($contacts));
      return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
    }catch (\Exception $e) {
      throw new \Exception("Falha ao buscar contato(s)!");
    }
  }

  public function create(ServerRequestInterface $request, ResponseInterface $response) {
    $contact = (array) $request->getParsedBody();
    
    try {
      $contactSaved = $this->contactService->save($contact);

      $response->getBody()->write(json_encode($contactSaved));
      return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);
    }catch (\Exception $e) {
      throw new \Exception("Falha ao cadastrar contato!");
    }
  }

  public function update(ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $contact = (array) $request->getParsedBody();
    $id = intval($args['id']);

    try {
      $contactUpdated = $this->contactService->update($contact, $id);

      $response->getBody()->write(json_encode($contactUpdated));
      return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
    } catch (\Exception $e) {
      throw new \Exception("Falha ao atualizar contato!");
    }
  }

  public function delete(ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $id = intval($args['id']);

    try {
      $this->contactService->delete($id);

      $response->getBody()->write(json_encode('Contato deletado com sucesso!'));
      return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
    }catch (\Exception $e) {
      throw new \Exception('Erro ao Deletar contato!');
    }
  }
}
