<?php

namespace WalkSafe\Views\Documents;

use WalkSafe\Views\Documents\PublicDocument;
use WalkSafe\Views\Elements\TextElement;

class ImpressumDocument extends PublicDocument {

    public function __construct() {
        parent::__construct(gettext("TITLE_IMPRESSUM"));
    }

    protected function setupHTML() {
        $this->addContent(new TextElement(
            sprintf(gettext("MESSAGE_RESPONSIBLE"), htmlentities($this->serverconfiguration->getResponsible())),
            gettext("SUBTITLE_RESPONSIBLE")
        ));
        $content = sprintf(
            gettext('%s<br />%s<br />%s<br /><a href="mailto:%s">%s</a>'),
            htmlentities($this->serverconfiguration->getImpressumPersonname()),
            htmlentities($this->serverconfiguration->getImpressumStreet()),
            htmlentities($this->serverconfiguration->getImpressumCity()),
            htmlentities($this->serverconfiguration->getImpressumEmail()),
            htmlentities($this->serverconfiguration->getImpressumEmail())
        );
        $this->addContent(new TextElement(
            $content,
            gettext("SUBTITLE_CONTACT")
        ));
    }

}
