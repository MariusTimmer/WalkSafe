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

/**
 * This has to be done before the first instance will be created:
 */
$locale =  Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
$locale .= '_'. strtoupper($locale);
Document::initI18n($locale .'.UTF-8');
