<?php

namespace WalkSafe\Views\Documents;

use WalkSafe\Views\Documents\PublicDocument;
use WalkSafe\Views\Elements\TextElement;

class StartDocument extends PublicDocument {

    public function __construct() {
        parent::__construct(gettext("TITLE_START"));
    }

    protected function setupHTML() {
        $this->addContent(new TextElement(gettext("TEXT_STARTDOCUMENT"), gettext("SUBTITLE_START")));
    }

}
