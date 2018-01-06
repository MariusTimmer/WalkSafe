<?php

namespace WalkSafe\Views\Documents;

use WalkSafe\Views\Documents\PublicDocument;
use WalkSafe\Views\Elements\TextElement;

class ErrorDocument extends PublicDocument {

    public function __construct($title, $message) {
        parent::__construct($title);
        $this->addContent(new TextElement($message, 'errormessage', 'errormessage'));
    }

}
