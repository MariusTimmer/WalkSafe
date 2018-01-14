<?php

namespace WalkSafe\Views\Documents;

use WalkSafe\Views\Documents\PublicDocument;
use WalkSafe\Views\Elements\TextElement;
use WalkSafe\Configuration;

class ImpressumDocument extends PublicDocument {

    public function __construct() {
        parent::__construct(gettext("TITLE_IMPRESSUM"));
    }

    protected function setupHTML() {
        $this->addContent(new TextElement(
            sprintf(
                gettext("MESSAGE_RESPONSIBLE"),
                Configuration::get('RESPONSIBLE', 'GENERAL')
            ),
            gettext("SUBTITLE_RESPONSIBLE")
        ));
        $content = sprintf(
            gettext('%s<br />%s<br />%s<br /><a href="mailto:%s">%s</a>'),
            htmlentities(Configuration::get('PERSON', 'IMPRESSUM')),
            htmlentities(Configuration::get('STREET', 'IMPRESSUM')),
            htmlentities(Configuration::get('CITY', 'IMPRESSUM')),
            htmlentities(Configuration::get('EMAIL', 'IMPRESSUM')),
            htmlentities(Configuration::get('EMAIL', 'IMPRESSUM'))
        );
        $this->addContent(new TextElement(
            $content,
            gettext("SUBTITLE_CONTACT")
        ));
    }

}
