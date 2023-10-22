<?php

namespace ContactsApi\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CompanyController {

  private static $table = 'company';

  public function __construct(
    protected \PDO $pdo
  ) { }

  public function findAll(ServerRequestInterface $request, ResponseInterface $response) {
    $sql = 'SELECT * FROM '.self::$table;
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() < 1) {
      throw new \Exception("Nenhuma empresa encontrada!");
    }

    $company = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $response->getBody()->write(json_encode($company));

    return $response
      ->withHeader('Content-Type', 'application/json')
      ->withStatus(200);
  }

  public function create(ServerRequestInterface $request, ResponseInterface $response) {
    $args = (array) $request->getParsedBody();
    
    $sql = 'INSERT INTO ' . self::$table . ' (name) VALUES (:name)';
    $stmt = $this->pdo->prepare($sql);
    
    if (isset($args) && !empty($args['name'])) {
      $stmt->bindValue(':name', $args['name']);
      $stmt->execute();
    }

    if ($stmt->rowCount() < 0) {
      throw new \Exception("Falha ao cadastrar empresa!");
    }

    $response->getBody()->write(json_encode($args));

    return $response
      ->withHeader('Content-Type', 'application/json')
      ->withStatus(201);
  }

  public function update(ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $company = (array) $request->getParsedBody();

    $sql = 'UPDATE '.self::$table.' SET name = :name WHERE id = :id';

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':name', $company['name']);
    $stmt->bindValue(':id', $args['id']);
    $stmt->execute();
    
    if ($stmt->rowCount() < 0) {
      throw new \Exception("Falha ao atualizar empresa!");
    }
    
    $response->getBody()->write(json_encode($company));

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
      throw new \Exception('Erro ao Deletar empresa!');
    }

    $stmt->closeCursor();

    $response->getBody()->write(json_encode('Empresa deletada com sucesso!'));
    return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
  }
}
