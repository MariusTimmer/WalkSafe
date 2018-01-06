<?php

namespace WalkSafe\Views\Elements;

use WalkSafe\Views\Elements\InputElement;

class SubmitElement extends InputElement {

    public function __construct($name, $value = '') {
        parent::__construct('submit', $name, $value);
    }

}
