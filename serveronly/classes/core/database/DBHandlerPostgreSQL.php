<?php

namespace WalkSafe\core\database;

use WalkSafe\Configurator;

class DBHandlerPostgreSQL extends DBHandler {

    protected function connect(): PDO {
        $dsn = sprintf(
            'pgsql:host=%s;dbname=%s',
            Configurator::get('DATABASE::HOSTNAME'),
            Configurator::get('DATABASE::DATABASENAME')
        );
        return new PDO(
            $dsn,
            Configurator::get('DATABASE::USERNAME'),
            trim(file_get_contents(Configurator::get('DATABASE::PASSWORDFILE'))),
            array (
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            )
        );
    }

}
