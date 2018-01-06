<?php

namespace WalkSafe\Views\Elements;

use WalkSafe\Views\IPrintable;

class TextElement implements IPrintable {

    protected $title;
    protected $text;

    public function __construct($text, $title = '') {
        $this->text = $text;
        $this->title = $title;
    }

    public function __toString() {
        $html = '<p>'. $this->text .'</p>';
        if (!empty($this->title)) {
            $html = '<h3>'. htmlentities($this->title) .'</h3>'. $html;
        }
        return $html;
    }

}
