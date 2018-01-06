<?php

namespace WalkSafe\Views\Elements;

use WalkSafe\Views\Elements\InputElement;

class PasswordInputElement extends InputElement {

    public function __construct($name, $value = '', $placeholder = '') {
        parent::__construct('password', $name, $value, $placeholder);
    }

}
