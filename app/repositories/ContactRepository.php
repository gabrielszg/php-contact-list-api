<?php

namespace ContactsApi\Repositories;

use ContactsApi\DB\Database;

class ContactRepository {

    private static $table = 'contacts';

    public function __construct() { }

    public function findAllOrFilterByParam(array $params) {
        $companyFilter = $params['company'] ?? null;
        $nameFilter = $params['name'] ?? null;
        $lastNameFilter = $params['last_name'] ?? null;
        $landlineFilter = $params['landline'] ?? null;
        $cellPhoneFilter = $params['cell_phone'] ?? null;
        $emailFilter = $params['email'] ?? null;

        $sql = 'SELECT * FROM ' . self::$table . ' WHERE 1=1';

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

        $stmt = Database::getInstance()->prepare($sql);

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

        return $result;
    }

    public function save(array $contact) {
        $sql = 'INSERT INTO ' . self::$table . ' (name, last_name, birth_date, landline, cell_phone, email, company_id)
        VALUES (:name, :last_name, :birth_date, :landline, :cell_phone, :email, :company_id)';
        $stmt = Database::getInstance()->prepare($sql);
    
        $stmt->bindValue(':name', $contact['name']);
        $stmt->bindValue(':last_name', $contact['last_name']);
        $stmt->bindValue(':birth_date', $contact['birth_date']);
        $stmt->bindValue(':landline', $contact['landline']);
        $stmt->bindValue(':cell_phone', $contact['cell_phone']);
        $stmt->bindValue(':email', $contact['email']);
        $stmt->bindValue(':company_id', $contact['company_id']);
        $stmt->execute();

        return $contact;
    }

    public function update(array $contact, int $id) {
        $sql = 'UPDATE '.self::$table.' SET
                name = :name, 
                last_name = :last_name, 
                birth_date = :birth_date, 
                landline = :landline, 
                cell_phone = :cell_phone, 
                email = :email
                
                WHERE id = :id';

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindValue(':name', $contact['name']);
        $stmt->bindValue(':last_name', $contact['last_name']);
        $stmt->bindValue(':birth_date', $contact['birth_date']);
        $stmt->bindValue(':landline', $contact['landline']);
        $stmt->bindValue(':cell_phone', $contact['cell_phone']);
        $stmt->bindValue(':email', $contact['email']);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $contact;
    }

    public function delete(int $id) {
        $sql = 'DELETE FROM '.self::$table.' WHERE id = :id';

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $stmt->closeCursor();
    }
}
