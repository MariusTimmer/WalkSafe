<?php

namespace WalkSafe\Views\Elements;

use WalkSafe\Views\Elements\Element;
use WalkSafe\Views\Elements\TextElement;
use WalkSafe\Views\Elements\LabelElement;

class KeyValueListElement extends Element {

    public function __construct($keyvalues = array(), $title = '', $description = '') {
        parent::__construct('div', array(
            'class' => 'keyvaluelist'
        ), false, '');
        $innerHTML = '';
        if ((!empty($title)) || (!empty($description))) {
            $innerHTML .= new TextElement($description, $title);
        }
        foreach ($keyvalues AS $label => $value) {
            $innerHTML .= new LabelElement($label, '', true) .'<span class="value">'. htmlentities($value) .'</span><br />';
        }
        $this->setInnerHTML($innerHTML);
    }

}
