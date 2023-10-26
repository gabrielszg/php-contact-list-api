<?php

namespace ContactsApi\Services;

use ContactsApi\Models\CompanyModel;
use ContactsApi\Repositories\CompanyRepository;

class CompanyService {

    private CompanyRepository $companyRepository;

    public function __construct() { 
        $this->companyRepository = new CompanyRepository();
    }

    public function findAll() {
        return $this->companyRepository->findAll();
    }

    public function save(CompanyModel $company): CompanyModel {
        return $this->companyRepository->save($company);
    }

    public function update(array $company, int $id) {
        return $this->companyRepository->update($company, $id);
    }

    public function delete(int $id) {
        return $this->companyRepository->delete($id);
    }
}
