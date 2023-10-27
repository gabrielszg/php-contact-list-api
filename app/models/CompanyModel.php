<?php

namespace ContactsApi\Models;

class CompanyModel {

    private int $id;
    private string $name;

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

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}