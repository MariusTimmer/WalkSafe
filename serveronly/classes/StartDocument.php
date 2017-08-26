<?php

class StartDocument extends PublicDocument {

    public function __construct() {
        parent::__construct(gettext("Start"));
    }

    protected function setupHTML() {
        $this->addContent(new TextElement(gettext("It is nice to see you here. This application allows you to search for a person to escort you or a person you can escort."), gettext("Welcome")));
    }

}
