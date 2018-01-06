<?php

/**
 * ServerConnector
 * This class is meant to connect the public php files to the server only
 * hidden scripts. In case the server files are not located at the default
 * location this class provides the ability to change a config file so all
 * files find the server only content.
 * @date 2018-01-06
 * @author Marius Timmer
 */
class ServerConnector {

    const CONFIGURATION_FILE    = '.serveronly.ini';
    const CONFIG_SECTION        = 'LOCATIONS';
    const CONFIG_KEY_ROOT       = 'ROOT';
    const CONFIG_KEY_AUTOLOADER = 'AUTOLOADER';

    public static function init() {
        $config = parse_ini_file(self::CONFIGURATION_FILE, true);
        if ($config === false) {
            /**
             * Somethin went wrong. Maybe the file does not exist,
             * is empty or not parsable. This is a fatal error.
             */
            print sprintf(
                "Could not parse or read first configuration file \"%s\"!",
                self::CONFIGURATION_FILE
            );
            die();
        }
        if ((!isset($config[self::CONFIG_SECTION])) ||
            (!isset($config[self::CONFIG_SECTION][self::CONFIG_KEY_ROOT])) ||
            (!isset($config[self::CONFIG_SECTION][self::CONFIG_KEY_AUTOLOADER]))) {
            /**
             * The required data were not found within the configuration
             * file which also is a fatal error.
             */
            print sprintf(
                "Required data (\"%s\" and \"%s\") not found in section \"%s\"",
                self::CONFIG_KEY_ROOT,
                self::CONFIG_KEY_AUTOLOADER,
                self::CONFIG_SECTION
            );
            die();
        }
        $autoloaderPath = $config[self::CONFIG_SECTION][self::CONFIG_KEY_ROOT]
            . DIRECTORY_SEPARATOR
            . $config[self::CONFIG_SECTION][self::CONFIG_KEY_AUTOLOADER];
        if (!is_readable($autoloaderPath)) {
            /**
             * Not able to read the file at the autoloader path which may mean
             * that it either does not exists or the permission to read it is
             * missing. This is alos an fatal error.
             */
            sprintf(
                "Could not read autoloader from file \"%s\"!",
                $autoloaderPath
            );
            die();
        }
        require_once($autoloaderPath);
    }

}
ServerConnector::init();