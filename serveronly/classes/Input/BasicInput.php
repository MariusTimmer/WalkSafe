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
     * The static stored data pool.
     * @var array $data
     */
    protected static $data;

    /**
     * This method will be implemented in the extending classes to set the
     * data pool to use (e.g. $_POST, $_GET, ...).
     * @return array Data pool to use
     */
    abstract protected static function getData(): array;

    /**
     * Will be called internally and make sure the data from the getData()
     * method is set if there is no data set yet. It is like a simple
     * static constructor.
     */
    protected static function provideData() {
        if (!static::$data) {
            static::$data = static::getData();
        }
    }

    /**
     * Reads out the requested data and returns it.
     * @param string $key The key of the data
     * @return mixed The requested data from the data pool
     */
    public static function get(string $key) {
        static::provideData();
        if (isset(static::$data[$key])) {
            return filter_var(static::$data[$key], FILTER_SANITIZE_STRING);
        }
        return null;
    }

}
