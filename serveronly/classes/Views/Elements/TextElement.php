<?php

namespace WalkSafe\Views\Elements;

use WalkSafe\Views\IPrintable;

class TextElement implements IPrintable {

    protected $title;
    protected $text;
    protected $classes;

    public function __construct($text, $title = '', $classes = array()) {
        $this->text = $text;
        $this->title = $title;
        $this->classes = $classes;
    }

    /**
     * Adds a class to the div element.
     * @param string $classname
     */
    public function addClass(string $classname) {
        array_push($this->classes, $classname);
    }

    public function __toString() {
        $html = '<div';
        if (count($this->classes) > 0) {
            $html .= ' class="'. implode(' ', $this->classes) .'"';
        }
        $html .= '>';
        if (!empty($this->title)) {
            $html .= '<b>'. htmlentities($this->title) .'</b>';
        }
        $html .= '<p>'. $this->text .'</p></div>';
        return $html;
    }

}
