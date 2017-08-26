<?php

class ErrorDocument extends PublicDocument {

    public function __construct($title, $message) {
        parent::__construct($title);
        $this->addContent(new TextElement($message, 'errormessage', 'errormessage'));
    }

}
