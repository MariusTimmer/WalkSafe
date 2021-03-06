<?php

namespace WalkSafe\Views\Elements;

use WalkSafe\Views\Elements\Element;

class LabelElement extends Element {

    public function __construct($label, $for = '', $right = false) {
        parent::__construct('label', array(
            'for' => $for
        ), false, $label);
        if ($right) {
            $this->addAttribute('class', 'right');
        }
    }

}
