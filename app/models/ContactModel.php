<?php

namespace ContactsApi\Models;

class ContactModel {

    private int $id;
    private string $name;
    private string $last_name;
    private string $birth_date;
    private string $landline;
    private string $cell_phone;
    private string $email;
    private CompanyModel $company;

    public function getId() {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName(string $name) {
        $this->name = $name;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function setLastName(string $last_name) {
        $this->last_name = $last_name;
    }

    public function getBirthDate() {
        return $this->birth_date;
    }

    public function setBirthDate(string $birth_date) {
        $this->birth_date = $birth_date;
    }

    public function getLandline() {
        return $this->landline;
    }

    public function setLandline(string $landline) {
        $this->landline = $landline;
    }

    public function getCellPhone() {
        return $this->cell_phone;
    }

    public function setCellPhone(string $cell_phone) {
        $this->cell_phone = $cell_phone;
    }
    
    public function getEmail() {
        return $this->email;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompany(CompanyModel $company) {
        $this->company = $company;
    }
}