<?php

abstract class DAO {

    protected $pdo;

    public function __construct() {
        $this->pdo = DatabaseManager::Build();
    }

}
