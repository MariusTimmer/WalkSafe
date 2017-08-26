<?php

class ImpressumDocument extends PublicDocument {

    public function __construct() {
        parent::__construct(gettext("Impressum"));
    }

    protected function setupHTML() {
        $this->addContent(new TextElement(
            sprintf(gettext("Responsible for this website and application is the operator %s but not for the user data."), htmlentities($this->serverconfiguration->getResponsible())),
            gettext("Responsibility")
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
            gettext("Contact")
        ));
    }

}
