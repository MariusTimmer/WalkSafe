<?php

namespace WalkSafe\Views\Elements;

use WalkSafe\Views\Elements\Element;
use WalkSafe\Views\Elements\SubmitElement;

class SigninFormElement extends Element {

    const KEY_USERNAME = 'username';
    const KEY_EMAIL = 'email';
    const KEY_PASSWORD = 'password';
    const KEY_SUBMIT = 'signin';

    public function __construct($action) {
        parent::__construct('form', array(
            'action' => $action,
            'method' => 'POST'
        ), false);
        $innerHTML  = '<p>'. gettext("MESSAGE_SIGNINFORM_INTRO") .'</p>';
        $innerHTML .= '<label for="'. self::KEY_USERNAME .'">'. gettext("LABEL_USERNAME") .':</label>'. new TextInputElement(self::KEY_USERNAME, '', gettext("EXAMPLE_NAME")) .'<br />';
        $innerHTML .= '<label for="'. self::KEY_EMAIL .'">'. gettext("LABEL_EMAIL") .':</label>'. new TextInputElement(self::KEY_EMAIL, '', gettext("EXAMPLE_EMAIL")) .'<br />';
        $innerHTML .= '<label for="'. self::KEY_PASSWORD .'">'. gettext("LABEL_PASSWORD") .':</label>'. new PasswordInputElement(self::KEY_PASSWORD, '', gettext("LABEL_PASSWORD"));
        $innerHTML .= new SubmitElement(self::KEY_SUBMIT, gettext("BUTTON_SIGNIN_SUBMIT"));
        $this->setInnerHTML($innerHTML);
    }

}
