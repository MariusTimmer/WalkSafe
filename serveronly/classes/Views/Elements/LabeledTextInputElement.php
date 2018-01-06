<?php

namespace WalkSafe\Views\Elements;

use WalkSafe\Views\IPrintable;
use WalkSafe\Views\Elements\LabelElement;
use WalkSafe\Views\Elements\TextInputElement;

class LabeledTextInputElement implements IPrintable {

    protected $label;
    protected $name;
    protected $value;

    public function __construct($label, $name, $value = '') {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
    }

    public function __toString() {
        $label_obj = new LabelElement($this->label, $this->name);
        $input_obj = new TextInputElement($this->name, $this->value);
        return $label_obj . $input_obj;
    }

}
