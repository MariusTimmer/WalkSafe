<?php

namespace WalkSafe\Views\Documents;

use WalkSafe\ServerConfiguration;
use WalkSafe\Input\PostInput;
use WalkSafe\Views\Documents\PublicDocument;
use WalkSafe\Views\Elements\SubmitElement;
use WalkSafe\Views\Elements\FormElement;
use WalkSafe\Views\Elements\TextElement;
use WalkSafe\Views\Elements\LabeledTextInputElement;

class InstallDocument extends PublicDocument {

    const KEY_TITLE = 'title';
    const KEY_FQDM = 'fqdm';
    const KEY_SYSADDRESS = 'sysaddress';
    const KEY_COPYRIGHT = 'copyright';
    const KEY_RESPONSIBLE = 'responsible';
    const KEY_IMPRESSUM_PERSONNAME = 'imp_personname';
    const KEY_IMPRESSUM_STREET = 'imp_street';
    const KEY_IMPRESSUM_CITY = 'imp_city';
    const KEY_IMPRESSUM_EMAIL = 'imp_email';
    const KEY_SUBMIT = 'submit';

    function __construct() {
        parent::__construct(gettext("Installation"));
    }

    protected function readInputData() {
        parent::readInputData();
    }

    protected function setupHTML() {
        $formContent  = new TextElement(
            sprintf(
                gettext("We have noticed that your system is not configured yet. Now we reached the point you need to configure it. Just fill out the following formular and confirm your input data clicking the submit button. To revert or change your configuration you can edit the \"%s\" file at any time."),
                sprintf(
                    '<code>%s</code>',
                    ServerConfiguration::FILENAME
                )
            )
        );
        $formContent .= new LabeledTextInputElement(
            gettext("Title"),
            self::KEY_TITLE,
            PostInput::get(self::KEY_TITLE)
        );
        $formContent .= new LabeledTextInputElement(
            gettext("Fully qualified domain name"),
            self::KEY_FQDM,
            PostInput::get(self::KEY_FQDM)
        );
        $formContent .= new LabeledTextInputElement(
            gettext("System address"),
            self::KEY_SYSADDRESS,
            PostInput::get(self::KEY_SYSADDRESS)
        );
        $formContent .= new LabeledTextInputElement(
            gettext("Copyright"),
            self::KEY_COPYRIGHT,
            PostInput::get(self::KEY_COPYRIGHT)
        );
        $formContent .= '<fieldset><legend>'. gettext("Impressum") .'</legend>';
        $formContent .= new LabeledTextInputElement(
            gettext("Responsible"),
            self::KEY_RESPONSIBLE,
            PostInput::get(self::KEY_RESPONSIBLE)
        );
        $formContent .= new LabeledTextInputElement(
            gettext("Person"),
            self::KEY_IMPRESSUM_PERSONNAME,
            PostInput::get(self::KEY_IMPRESSUM_PERSONNAME)
        );
        $formContent .= new LabeledTextInputElement(
            gettext("Street"),
            self::KEY_IMPRESSUM_STREET,
            PostInput::get(self::KEY_IMPRESSUM_STREET)
        );
        $formContent .= new LabeledTextInputElement(
            gettext("City"),
            self::KEY_IMPRESSUM_CITY,
            PostInput::get(self::KEY_IMPRESSUM_CITY)
        );
        $formContent .= new LabeledTextInputElement(
            gettext("Email"),
            self::KEY_IMPRESSUM_EMAIL,
            PostInput::get(self::KEY_IMPRESSUM_EMAIL)
        );
        $formContent .= '</fieldset>';
        $formContent .= new SubmitElement(
            self::KEY_SUBMIT,
            gettext("Save")
        );
        $formular = new FormElement('', $formContent);
        $this->addContent($formular);
    }

}