<?php

namespace WalkSafe\Views\Elements;

use WalkSafe\Views\Elements\Element;

class FormElement extends Element {

    public function __construct($action, $innerHTML) {
        parent::__construct('form', array(
            'action' => $action,
            'method' => 'POST'
        ), false, $innerHTML);
    }

}
