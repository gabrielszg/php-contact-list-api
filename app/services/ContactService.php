<?php

namespace ContactsApi\Services;

use ContactsApi\Repositories\ContactRepository;

class ContactService {

    private ContactRepository $contactRepository;

    public function __construct() { 
        $this->contactRepository = new ContactRepository();
    }

    public function findAllOrFilterByParam(array $params) {
        return $this->contactRepository->findAllOrFilterByParam($params);
    }

    public function save(array $contact) {
        return $this->contactRepository->save($contact);
    }

    public function update(array $contact, int $id) {
        return $this->contactRepository->update($contact, $id);
    }

    public function delete(int $id) {
        return $this->contactRepository->delete($id);
    }
}