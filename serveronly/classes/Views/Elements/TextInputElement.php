<?php

class TextInputElement extends InputElement {

    public function __construct($name, $value = '', $placeholder = '') {
        parent::__construct('text', $name, $value, $placeholder);
    }

}
