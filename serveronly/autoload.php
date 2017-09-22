<?php

define('SERVERONLY_ROOT', __DIR__);
define('DIRECTORY_CLASSES', SERVERONLY_ROOT . DIRECTORY_SEPARATOR .'classes');
define('DIRECTORY_CLASSES_CONTROLS', DIRECTORY_CLASSES . DIRECTORY_SEPARATOR .'Controls');
define('DIRECTORY_CLASSES_MODELS', DIRECTORY_CLASSES . DIRECTORY_SEPARATOR .'Models');
define('DIRECTORY_CLASSES_VIEWS', DIRECTORY_CLASSES . DIRECTORY_SEPARATOR .'Views');
define('DIRECTORY_CLASSES_VIEWS_DOCUMENTS', DIRECTORY_CLASSES_VIEWS . DIRECTORY_SEPARATOR .'Documents');
define('DIRECTORY_CLASSES_VIEWS_ELEMENTS', DIRECTORY_CLASSES_VIEWS . DIRECTORY_SEPARATOR .'Elements');

/**
 * Loads required scripts. Suffix of the class name will be used to locate the
 * according script. If it can not be found using the name it will be searched
 * using the known directories.
 * @param string $classname Name of the required class
 * @return boolean True on success or false
 */
function __autoload($classname) {
    $directories = array(
        'Control' => DIRECTORY_CLASSES_CONTROLS,
        'Model' => DIRECTORY_CLASSES_MODELS,
        'View' => DIRECTORY_CLASSES_VIEWS,
        'Document' => DIRECTORY_CLASSES_VIEWS_DOCUMENTS,
        'Element' => DIRECTORY_CLASSES_VIEWS_ELEMENTS,
        'Class' => DIRECTORY_CLASSES
    );
    for ($i = 0; $i < 2; $i++) {
        foreach ($directories AS $suffix => $directory) {
            if (($i === 1) ||
                (substr($classname, 0 - strlen($suffix)) === $suffix)) {
                $filename = $directory . DIRECTORY_SEPARATOR . $classname .'.php';
                if (file_exists($filename)) {
                    return require_once $filename;
                }
            }
        }
    }
    return false;
}

/**
 * This has to be done before the first instance will be created:
 */
$locale =  Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
$locale .= '_'. strtoupper($locale);
Document::initI18n($locale .'.UTF-8');
