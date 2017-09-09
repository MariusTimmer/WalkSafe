<?php

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
