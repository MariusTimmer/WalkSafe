<?php

namespace WalkSafe;

use Exception;

class Configuration {

    const CONFIGURATIONFILE = SERVERONLY_ROOT . DIRECTORY_SEPARATOR .'server.ini';
    private static $data = null;

    /**
     * Reads in the configuration file.
     * @return bool True on success or false
     */
    private static function read(): bool {
        if (!is_readable(self::CONFIGURATIONFILE)) {
            trigger_error("Configuration file not found");
            return false;
        }
        self::$data = parse_ini_file(self::CONFIGURATIONFILE, true, INI_SCANNER_TYPED);
        if (self::$data === false) {
            trigger_error("Could not read configuration file");
            return false;
        }
        return true;
    }

    /**
     * Stores the current configuration info the configuration file.
     * @return bool True on success or false
     */
    public static function store(): bool {
        if (empty(self::$data)) {
            /**
             * There is no need to store an empty configuration.
             */
            return false;
        }
        $fh = fopen(self::CONFIGURATIONFILE, 'w');
        if (!$fh) {
            return false;
        }
        fprintf(
            $fh,
            "; Server configuration\n; Automatic generated configuration file\n; %s\n\n",
            date('y-m-d h:i:s')
        );
        foreach (self::$data AS $section => $sectionData) {
            fprintf($fh, "\n[%s]\n", $section);
            foreach ($sectionData AS $key => $value) {
                fprintf(
                    $fh,
                    "%s = \"%s\"\n",
                    $key,
                    $value
                );
            }
        }
        return fclose($fh);
    }

    /**
     * Sets a new value for the given key in the requested section.
     * If $value is empty a set value will be removed.
     * @param string $key
     * @param string $section
     * @param mixed $value
     * @return bool
     */
    public static function set(string $key, string $section, $value = null): bool {
        if ((empty($key)) ||
            (empty($section))) {
            return false;
        }
        if (is_null(self::$data)) {
            self::read();
        }
        if (empty($value)) {
            /**
             * Empty values will be interpreted as the wish to remove a value
             */
            unset(self::$data[$section][$key]);
        } else {
            self::$data[$section][$key] = $value;
        }
        return true;
    }

    /**
     * Returns a value from the configuration file. Values can be fetched using
     * a key and section separated or connecting them using a :: as a key.
     * @param string $key
     * @param string $section
     * @return string|null
     */
    public static function get(string $key, $section = null) {
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
