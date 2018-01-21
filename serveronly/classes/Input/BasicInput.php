<?php

namespace WalkSafe\Input;

/**
 * Basic Input class
 * This class provides the simple access (reading) methods to access
 * information within a data pool like $_POST, $_GET, etc.. It is meant
 * to be a wrapper class.
 * @author Marius Timmer
 */
abstract class BasicInput {

    /**
     * This method will be implemented in the extending classes to give the
     * data pool to use (e.g. $_POST, $_GET, ...).
     * @return array Data pool to use
     */
    abstract protected static function getData(): array;

    /**
     * Reads out the requested data and returns it.
     * @param string $key The key of the data
     * @return mixed The requested data from the data pool
     */
    public static function get(string $key) {
        $data = static::getData();
        if (isset($data[$key])) {
            return filter_var($data[$key], FILTER_SANITIZE_STRING);
        }
        return null;
    }

}
