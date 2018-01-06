<?php

namespace WalkSafe\Views\Elements;

use WalkSafe\Views\Elements\InputElement;

class ButtonElement extends InputElement {

    public function __construct($type, $name, $value = '', $onclick = '') {
        parent::__construct('button', $name, $value);
        $this->addAttribute('onclick', $onclick);
    }

}