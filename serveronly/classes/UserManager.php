<?php

class UserManager {

    protected $pdo;

    public function __construct() {
        $this->pdo = DatabaseManager::Build();
    }

    public function getUserById($userid) {
        $query = 'SELECT userid, username, email, created FROM users WHERE userid = :userid';
        return $this->pdo->executeQuery($query, array(
            'userid' => $userid
        ), false);
    }

}
