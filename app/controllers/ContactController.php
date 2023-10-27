<?php

namespace ContactsApi\Controllers;

use ContactsApi\Models\ContactModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ContactsApi\Services\ContactService;

class ContactController {

  private ContactService $contactService;

  public function __construct() { 
    $this->contactService = new ContactService();
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
    $data = (object) $request->getParsedBody();
    
    $contact = new ContactModel();
    $contact->setName($data->name);
    $contact->setLastName($data->last_name);
    $contact->setBirthDate($data->birth_date);
    $contact->setLandline($data->landline);
    $contact->setCellPhone($data->cell_phone);
    $contact->setEmail($data->email);
    $contact->setCompanyId($data->company_id);
    
    try {
      $contactSaved = $this->contactService->save($contact);

      $response->getBody()->write(json_encode($contactSaved->jsonSerialize()));
      return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);
    }catch (\Exception $e) {
      throw new \Exception("Falha ao cadastrar contato! ".$e);
    }
  }

  public function update(ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $data = (object) $request->getParsedBody();
    $id = intval($args['id']);

    $contact = new ContactModel();
    $contact->setName($data->name);
    $contact->setLastName($data->last_name);
    $contact->setBirthDate($data->birth_date);
    $contact->setLandline($data->landline);
    $contact->setCellPhone($data->cell_phone);
    $contact->setEmail($data->email);
    $contact->setCompanyId($data->company_id);

    try {
      $contactUpdated = $this->contactService->update($contact, $id);

      $response->getBody()->write(json_encode($contactUpdated->jsonSerialize()));
      return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
    } catch (\Exception $e) {
      throw new \Exception("Falha ao atualizar contato! ".$e);
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
