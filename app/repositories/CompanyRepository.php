<?php

namespace ContactsApi\Repositories;

use ContactsApi\DB\Database;
use ContactsApi\Models\CompanyModel;

class CompanyRepository {

    private static $table = 'company';

    public function __construct() { }

    public function findAll() {
        $sql = 'SELECT * FROM '.self::$table;

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute();

        $companies = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $companies;
    }

    public function save(CompanyModel $company) {
        $sql = 'INSERT INTO ' . self::$table . ' (name) VALUES (:name)';

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindValue(':name', $company->getName());
        $stmt->execute();

        return $company;
    }

    public function update(CompanyModel $company, int $id) {
        $sql = 'UPDATE '.self::$table.' SET name = :name WHERE id = :id';

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindValue(':name', $company->getName());
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $company;
    }

    public function delete(int $id) {
        $sql = 'DELETE FROM '.self::$table.' WHERE id = :id';

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $stmt->closeCursor();
    }
}