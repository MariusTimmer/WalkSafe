<?php

class JobManager {

    protected $pdo;

    public function __construct() {
        $this->pdo = DatabaseManager::Build();
    }

    public function getActiveJobRequests($userid) {
        $query = 'SELECT requestid, requestor, type, title, description, appointmenttime, locationid, created FROM jobrequests WHERE userid = :userid';
        return $this->pdo->executeQuery($query, array(
            'userid' => $userid
        ));
    }

}
