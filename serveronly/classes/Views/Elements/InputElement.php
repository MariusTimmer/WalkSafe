<?php

namespace WalkSafe\Views\Elements;

use WalkSafe\Views\Elements\Element;

abstract class InputElement extends Element {

    public function __construct($type, $name, $value = '', $placeholder = '') {
        parent::__construct('input', array(
            'type' => $type,
            'name' => $name,
            'id' => $name,
            'value' => $value,
            'placeholder' => $placeholder
        ));
    }

}