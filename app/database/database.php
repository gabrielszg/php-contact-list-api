<?php

namespace ContactsApi\DB;

class Database {

    public static $instance;

    private const HOST = 'localhost';
    private const PORT = '3306';
    private const DATABASE_NAME = 'enterprise';
    private const USER = 'root';
    private const PASSWORD = 'user123';

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new \PDO('mysql:host='.self::HOST.';port='.self::PORT.';dbname='.self::DATABASE_NAME, self::USER, self::PASSWORD);
            self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return self::$instance;
    }
}