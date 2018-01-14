<?php

/**
 * First of all we need to set up a few constants which will be used in the
 * whole application to find required directories.
 */
define('SERVERONLY_ROOT', __DIR__);
define('DIRECTORY_CLASSES', SERVERONLY_ROOT . DIRECTORY_SEPARATOR .'classes');
define('DIRECTORY_LOCALE', SERVERONLY_ROOT . DIRECTORY_SEPARATOR .'locale');
define('DIRECTORY_VARIOUS', SERVERONLY_ROOT . DIRECTORY_SEPARATOR .'var');

/**
 * This base autoloader will load all classes within the WalkSafe package.
 * Extensions and other libraries will be skipped which is why they need to
 * have an own autoloader stacked on this one.
 */
$baseAutoloader = function($classname) {
    $parts = explode(chr(92), $classname);
    if (array_shift($parts) !== 'WalkSafe') {
        /**
         * The requested class is not within the WalkSafe package which
         * means this autoloader will not be able to load it.
         */
        return false;
    }
    $filename = implode(
        DIRECTORY_SEPARATOR,
        array(
            DIRECTORY_CLASSES,
            implode(
                DIRECTORY_SEPARATOR,
                $parts
            ) .'.php'
        )
    );
    if (!file_exists($filename)) {
        return false;
    }
    require_once($filename);
    return true;
};
spl_autoload_register($baseAutoloader);

/**
 * This is a bit dirty, but the request processor should always be available at
 * first because it is (for example) required to provide correct translations.
 */
WalkSafe\Controls\RequestProcessor::init();
