<?php

class SubmitElement extends InputElement {

    public function __construct($name, $value = '') {
        parent::__construct('submit', $name, $value);
    }

}
