<?php

class JobRequestDocument extends MemberDocument {

    const MODE_REQUESTLIST = 'list';
    const MODE_REQUEST_FORMULAR = 'newrequest';
    const MODE_REQUEST_ADD = 'add';
    const MODE_DEFAULT = self::MODE_REQUESTLIST;
    const KEY_MODE = 'mode';

    protected $mode;

    public function __construct() {
        parent::__construct(gettext("Job requests"));
    }

    protected function readInputData() {
        $this->mode = $this->getValue(self::KEY_MODE);
        if (($this->mode !== self::MODE_REQUESTLIST) &&
            ($this->mode !== self::MODE_REQUEST_FORMULAR) &&
            ($this->mode !== self::MODE_REQUEST_ADD)) {
            /**
             * There was no mode or it was invalid so we use the default.
             */
            $this->mode = self::MODE_DEFAULT;
        }
    }

    protected function setupHTML() {
        switch ($this->mode) {
            case self::MODE_REQUESTLIST:
                $this->addContent(new TextElement(
                    '<label for="newrequest">'. gettext("You can add a new job request by clicking on the plus icon below") .':</label><a href="?mode='. self::MODE_REQUEST_FORMULAR .'" target="_self"><img id="newrequest" title="'. gettext("Add a new job request") .'" class="icon button" src="img/add.png" alt="'. gettext("New job request") .'" /></a>',
                    gettext("New job request")
                ));
                break;
        }
    }

}
