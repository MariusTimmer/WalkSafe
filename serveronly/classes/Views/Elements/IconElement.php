<?php

namespace WalkSafe\Views\Elements;

use WalkSafe\Views\Elements\Element;

class IconElement extends Element {

    /**
     * This class provides an icon image which will be loaded using javascript.
     * @param string $icon Name of the icon (without file extension)
     * @param string $alternative Alternative text for the case there is no image file
     */
    public function __construct($icon, $id = '', $alternative = '') {
        parent::__construct('img', array(
            'src'  => '',
            'icon' => $icon,
            'id' => $id,
            'class' => 'postload icon',
            'alt'  => $alternative
        ), true);
    }

}
