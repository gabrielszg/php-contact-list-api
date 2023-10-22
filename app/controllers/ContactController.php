<?php

namespace ContactsApi\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ContactController
{

  private static $table = 'contacts';

  public function __construct(
    protected \PDO $pdo
  ) {
  }

  public function findAllOrFilterByParam(ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $params = $request->getQueryParams();

    $companyFilter = $params['company'] ?? null;
    $nameFilter = $params['name'] ?? null;
    $lastNameFilter = $params['last_name'] ?? null;
    $landlineFilter = $params['landline'] ?? null;
    $cellPhoneFilter = $params['cell_phone'] ?? null;
    $emailFilter = $params['email'] ?? null;

    $sql = 'SELECT * FROM '.self::$table.' WHERE 1=1';

    if ($companyFilter) {
      $sql = ' SELECT ct.* FROM contacts ct JOIN company c ON ct.company_id = c.id WHERE c.name = :company';
    }

    if ($nameFilter) {
      $sql .= ' AND name = :name';
    }

    if ($lastNameFilter) {
      $sql .= ' AND last_name = :last_name';
    }

    if ($landlineFilter) {
      $sql .= ' AND landline = :landline';
    }

    if ($cellPhoneFilter) {
      $sql .= ' AND cell_phone = :cell_phone';
    }

    if ($emailFilter) {
      $sql .= ' AND email = :email';
    }

    $stmt = $this->pdo->prepare($sql);

    if ($companyFilter) {
      $stmt->bindParam(':company', $companyFilter);
    }

    if ($nameFilter) { 
      $stmt->bindParam(':name', $nameFilter);
    }

    if ($lastNameFilter) { 
      $stmt->bindParam(':last_name', $lastNameFilter);
    }

    if ($landlineFilter) {
      $stmt->bindParam(':landline', $landlineFilter);
    }

    if ($cellPhoneFilter) {
      $stmt->bindParam(':cell_phone', $cellPhoneFilter);
    }

    if ($emailFilter) {
      $stmt->bindParam(':email', $emailFilter);
    }

    $stmt->execute();
    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
   
    $response->getBody()->write(json_encode($result));

    return $response
      ->withHeader('Content-Type', 'application/json')
      ->withStatus(200);
  }

  public function create(ServerRequestInterface $request, ResponseInterface $response) {
    $args = (array) $request->getParsedBody();
    
    $sql = 'INSERT INTO ' . self::$table . ' (name, last_name, birth_date, landline, cell_phone, email, company_id)
    VALUES (:name, :last_name, :birth_date, :landline, :cell_phone, :email, :company_id)';
    $stmt = $this->pdo->prepare($sql);
    
    if (isset($args) && !empty($args['name'])) {
      $stmt->bindValue(':name', $args['name']);
      $stmt->bindValue(':last_name', $args['last_name']);
      $stmt->bindValue(':birth_date', $args['birth_date']);
      $stmt->bindValue(':landline', $args['landline']);
      $stmt->bindValue(':cell_phone', $args['cell_phone']);
      $stmt->bindValue(':email', $args['email']);
      $stmt->bindValue(':company_id', $args['company_id']);
      $stmt->execute();
    }

    if ($stmt->rowCount() < 0) {
      throw new \Exception("Falha ao cadastrar contato!");
    }

    $response->getBody()->write(json_encode($args));

    return $response
      ->withHeader('Content-Type', 'application/json')
      ->withStatus(201);
  }

  public function update(ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $contact = (array) $request->getParsedBody();

    $sql = 'UPDATE '.self::$table.' SET
      name = :name, 
      last_name = :last_name, 
      birth_date = :birth_date, 
      landline = :landline, 
      cell_phone = :cell_phone, 
      email = :email
      
      WHERE id = :id';

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':name', $contact['name']);
    $stmt->bindValue(':last_name', $contact['last_name']);
    $stmt->bindValue(':birth_date', $contact['birth_date']);
    $stmt->bindValue(':landline', $contact['landline']);
    $stmt->bindValue(':cell_phone', $contact['cell_phone']);
    $stmt->bindValue(':email', $contact['email']);
    $stmt->bindValue(':id', $args['id']);
    $stmt->execute();
    
    if ($stmt->rowCount() < 0) {
      throw new \Exception("Falha ao atualizar contato!");
    }
    
    $response->getBody()->write(json_encode($contact));

    return $response
      ->withHeader('Content-Type', 'application/json')
      ->withStatus(200);
  }

  public function delete(ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $sql = 'DELETE FROM '.self::$table.' WHERE id = :id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $args['id']);
    $stmt->execute();

    if ($stmt->rowCount() < 1) {
      throw new \Exception('Erro ao Deletar contato!'); 
    }

    $stmt->closeCursor();

    $response->getBody()->write(json_encode('Contato deletado com sucesso!'));
    return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
  }
}
