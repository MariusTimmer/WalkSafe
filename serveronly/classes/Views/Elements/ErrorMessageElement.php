<?php

namespace WalkSafe\Views\Elements;

/**
 * @author timmer
 */
class ErrorMessageElement extends TextElement {

    public function __construct($text, $title = '') {
        parent::__construct($text, $title, array('errormessage'));
    }

}
