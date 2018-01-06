<?php

namespace WalkSafe\Views\Documents;

use WalkSafe\Views\Documents\MemberDocument;

class HomeDocument extends MemberDocument {

    public function __construct() {
        parent::__construct(gettext("TITLE_HOME"));
    }

    protected function setupHTML() {
        $user = $this->getCurrentUser();
        $title = sprintf(gettext("SUBTITLE_HOME_WELCOME"), $user['username']);
        $content = gettext("MESSAGE_HOME_WELCOME");
        $this->addContent(new TextElement($content, $title));
    }

}
