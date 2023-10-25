<?php

namespace ContactsApi\Repositories;

class CompanyRepository {

    private static $table = 'company';

    public function __construct(
        protected \PDO $pdo
    ) { }

    public function findAll() {
        $sql = 'SELECT * FROM '.self::$table;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $companies = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $companies;
    }

    public function save(array $company) {
        $sql = 'INSERT INTO ' . self::$table . ' (name) VALUES (:name)';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name', $company['name']);
        $stmt->execute();

        return $company;
    }

    public function update(array $company, int $id) {
        $sql = 'UPDATE '.self::$table.' SET name = :name WHERE id = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name', $company['name']);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $company;
    }

    public function delete(int $id) {
        $sql = 'DELETE FROM '.self::$table.' WHERE id = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $stmt->closeCursor();
    }
}