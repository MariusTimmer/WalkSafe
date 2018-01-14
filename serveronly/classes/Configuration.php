<?php

namespace WalkSafe;

class Configuration {

    const CONFIGURATIONFILE = SERVERONLY_ROOT . DIRECTORY_SEPARATOR .'server.ini';
    private static $data = null;

    /**
     * Reads in the configuration file.
     * @throws Exception
     */
    private static function read() {
        if (!is_readable(self::CONFIGURATIONFILE)) {
            throw Exception("Configuration file not found");
        }
        self::$data = parse_ini_file(self::CONFIGURATIONFILE, true, INI_SCANNER_TYPED);
        if (self::$data === false) {
            throw new Exception("Could not read configuration file");
        }
    }

    /**
     * Returns a value from the configuration file. Values can be fetched using
     * a key and section separated or connecting them using a :: as a key.
     * @param string $key
     * @param string $section
     * @return string|null
     */
    public static function get(string $key, string $section = null) {
        if (!is_null($section)) {
            $key = $section .'::'. $key;
        }
        if (is_null(self::$data)) {
            self::read();
        }
        if (strpos($key, '::') === false) {
            return self::$data[$key];
        } else {
            $path = explode('::', $key);
            if ((isset(self::$data[$path[0]])) &&
                (isset(self::$data[$path[0]][$path[1]]))) {
                return self::$data[$path[0]][$path[1]];
            }
        }
        return null;
    }

    /**
     * Determinates weather the configuration file exists and is filled.
     * @return bool
     */
    public static function exists(): bool {
        if (!file_exists(self::CONFIGURATIONFILE)) {
            return false;
        }
        try {
            return (
                !empty(
                    self::get(
                        'TITLE',
                        'GENERAL'
                    )
                )
            );
        } catch (Exception $exception) {
            return false;
        }
    }

}
