<?php

class PasswordInputElement extends InputElement {

    public function __construct($name, $value = '', $placeholder = '') {
        parent::__construct('password', $name, $value, $placeholder);
    }

}
