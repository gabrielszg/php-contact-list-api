<?php

namespace ContactsApi\Services;

use ContactsApi\Repositories\CompanyRepository;

class CompanyService {

    private CompanyRepository $companyRepository;

    public function __construct(
        protected \PDO $pdo
    )
    { 
        $this->companyRepository = new CompanyRepository($pdo);
    }

    public function findAll() {
        return $this->companyRepository->findAll();
    }

    public function save(array $company) {
        return $this->companyRepository->save($company);
    }

    public function update(array $company, int $id) {
        return $this->companyRepository->update($company, $id);
    }

    public function delete(int $id) {
        return $this->companyRepository->delete($id);
    }
}
