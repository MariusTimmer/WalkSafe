<?php

class ButtonElement extends InputElement {

    public function __construct($type, $name, $value = '', $onclick = '') {
        parent::__construct('button', $name, $value);
        $this->addAttribute('onclick', $onclick);
    }

}