<?php

class HomeDocument extends MemberDocument {

    public function __construct() {
        parent::__construct(gettext("Home"));
    }

    protected function setupHTML() {
        $user = $this->getCurrentUser();
        $title = sprintf(gettext("Welcome %s!"), $user['username']);
        $content = gettext("We are glad to see you here.");
        $this->addContent(new TextElement($content, $title));
    }

}
