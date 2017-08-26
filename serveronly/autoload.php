<?php

define('SERVERONLY_ROOT', __DIR__);

/**
 * Loads the class scripts if they are required.
 * @param string $classname Name of the required class
 * @return boolean True on success or false
 */
function __autoload($classname) {
    $filename = implode(DIRECTORY_SEPARATOR, array(
        __DIR__,
        'classes',
        $classname .'.php'
    ));
    if (file_exists($filename)) {
        require_once($filename);
        return true;
    }
    return false;
}
