<?php

namespace WalkSafe\Views\Elements;

use WalkSafe\Views\Elements\Element;

class SelectElement extends Element {

    /**
     * Creates a new select box.
     * @param string $name Name of the select box
     * @param array $data Associative array containing the list elements (value => label)
     * @param string $classname Optional class name of the element
     * @param string $defaultSelection Optional default value to be selected
     */
    public function __construct(string $name, array $data, string $classname = '', $defaultSelection = '') {
        parent::__construct('select', array(
            'name' => $name,
            'id' => $name,
            'class' => $classname,
        ), false);
        foreach ($data AS $value => $label) {
            $this->addOption(
                $value,
                $label,
                ($value === $defaultSelection)
            );
        }
    }

    /**
     * Adds a new option to the selectable list.
     * @param string $value Value of the option
     * @param string $label Label which will be shown in the list
     * @param bool $default True to set this option as default
     */
    public function addOption(string $value, string $label, bool $default = false) {
        $this->innerHTML .= sprintf(
            '<option value="%s"%s>%s</option>',
            $value,
            ($default) ? ' selected="selected"' : '',
            htmlentities($label)
        );
    }

}
