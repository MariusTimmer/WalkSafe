<?php

abstract class Configuration {

    private $filename;
    private $data;

    /**
     * Creates a new instance of a configuration.
     * @param string $filename Name of the configurationfile to use
     */
    public function __construct($filename) {
        $this->filename = $filename;
        $this->read();
    }

    private function read() {
        if ((!file_exists($this->filename)) ||
            (!is_readable($this->filename))) {
            /**
             * The file is not available or not readable. This is an error.
             */
            return false;
        }
        $json = json_decode(trim(file_get_contents($this->filename)), true);
        if (!$json) {
            /**
             * Could not read the files content or parse it to a json object.
             */
            return false;
        }
        foreach ($json AS $key => $value) {
            $this->data[strtoupper($key)] = $value;
        }
    }

    /**
     * Returns a requested value from the configuration file by its key.
     * @param string $key Key of the value
     * @return string Value from the configuration
     */
    protected function getValue($key) {
        return $this->data[strtoupper($key)];
    }

    /**
     * Returns the name of the currently used file.
     * @return string Name of the configuration file
     */
    public function getFilename() {
        return $this->filename;
    }

}
