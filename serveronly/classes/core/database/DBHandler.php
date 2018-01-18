<?php

namespace WalkSafe\core\database;

/**
 * Database handler class
 * To wrap the PDO database connection and use a unified
 * interface for database transactions.
 * @author Marius Timmer
 */
abstract class DBHandler {

    /**
     * Wrapped database connection.
     * @var PDO
     */
    private static $connection = null;

    /**
     * @throws Exception No database connection available
     */
    private function __construct() {
        if (is_null(self::$connection)) {
            try {
                if (!$this->checkPasswordFile()) {
                    throw new Exception(
                        gettext("Permissions of the password file are public or it is not readable")
                    );
                }
                self::$connection = $this->connect();
            } catch (Exception $exception) {
                /**
                 * To prevent a printed stacktrace containing
                 * privileged information we catch the
                 * exception and throw a new one.
                 */
                throw new Exception(
                    sprintf(
                        "Connecting to DB failed (%s)",
                        $exception->getMessage()
                    )
                );
            }
        }
        if (is_null(self::$connection)) {
            /**
             * The connection is still null which means the connect
             * failed. In this case we should throw a new exception
             * which can be catched.
             */
            throw new Exception("DB connection is still null");
        }
    }

    protected static function getConnection(): PDO {
        if (is_null(self::$connection)) {
            /**
             * Just to be sure we create a new instance of the
             * DBHandler so the static connection is available.
             * We do not need the instance after this.
             */
            new self();
        }
        return self::$connection;
    }

    public function beginTransaction(): bool {
        return self::$connection->beginTransaction();
    }

    public function commit(): bool {
        return self::$connection->commit();
    }

    public function rollBack(): bool {
        return self::$connection->rollBack();
    }

    public function inTransaction(): bool {
        return self::$connection->inTransaction();
    }

    public function errorCode() {
        return self::$connection->errorCode();
    }

    public function errorInfo(): array {
        return self::$connection->errorInfo();
    }

    public function exec(string $statement): int {
        return self::$connection->exec($statement);
    }

    public function query(string $statement): array {
        return self::$connection->query(
            $statement,
            PDO::FETCH_ASSOC
        );
    }

    public function executePrepared(string $statement, array $parameter = array ()): array {
        $preparedStatement = self::$connection->prepare($statement);
        foreach ($parameter AS $key => &$value) {
            $preparedStatement->bindParam(':' . $key, $value);
        }
        if (!$preparedStatement->execute()) {
            return array ();
        }
        return $preparedStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Returns the file name of a query.
     * @param string $queryName Name of the query
     * @return string Path to the file containing the query
     */
    public function getQueryFilename(string $queryName): string {
        return implode(
            DIRECTORY_SEPARATOR, array (
            DIRECTORY_VARIOUS,
            'queries',
            $queryName
            )
        ) . '.sql';
    }

    /**
     * Executes a query stored in a query file.
     * @param string $queryName Name of the query file to use
     * @return array|bool The result of the query or false in case of an error
     */
    public function executeQuery(string $queryName) {
        $queryFile = $this->getQueryFilename($queryName);
        if (!file_exists($queryFile)) {
            return false;
        }
        $query = file_get_contents($queryFile);
        if (empty($query)) {
            return false;
        }
        return $this->query($query);
    }

    /**
     * Checks weather the password file is accessable for the group or world
     * which would cause an error. Additionally it will be checked weather
     * the file is readable.
     * @return bool True if the password file is okay or false
     */
    public function checkPasswordFile(): bool {
        $passwordfile = Configurator::get('DATABASE::PASSWORDFILE');
        if (empty($passwordfile)) {
            /**
             * There is no password file available in the current configuration
             */
            return false;
        }
        $fileMode = substr(
            sprintf(
                '%o',
                fileperms($passwordfile)
            ),
            -4
        );
        if ((substr($fileMode, -2, 1) !== 0) ||
            (substr($fileMode, -1, 1) !== 0) ||
            (!is_readable($passwordfile))) {
            /**
             * The password file is accessable by the group or (even worse)
             * the world or is not readable for us which also could mean that
             * the file does not exists.
             */
            return false;
        }
        return true;
    }

    /**
     * Set up the PDO connection to the database reading the configuration
     * returning the established connection.
     * The simplest implementation would look something like:
     * return new PDO(...);
     * @return PDO Established connection
     * @uses \WalkSafe\Configuration Database parameters from configuration
     */
    abstract protected function connect(): PDO;

}
