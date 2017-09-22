<?php

class LoginFormElement extends Element {

    const KEY_USERNAME = 'username';
    const KEY_PASSWORD = 'password';
    const KEY_SUBMIT = 'login';

    public function __construct($action) {
        parent::__construct('form', array(
            'action' => $action,
            'method' => 'POST'
        ), false);
        $innerHTML  = '<p>'. gettext("MESSAGE_LOGINFORM_INTRO") .'</p>';
        $innerHTML .= '<fieldset><legend>'. gettext("USE_CREDENTIALS") .'</legend>';
        $innerHTML .= '<label for="'. self::KEY_USERNAME .'">'. gettext("LABEL_USERNAME") .':</label>'. new TextInputElement(self::KEY_USERNAME, '', gettext("EXAMPLE_USERNAME")) .'<br />';
        $innerHTML .= '<label for="'. self::KEY_PASSWORD .'">'. gettext("LABEL_PASSWORD") .':</label>'. new PasswordInputElement(self::KEY_PASSWORD, '', gettext("LABEL_PASSWORD"));
        $innerHTML .= '</fieldset>';
        $innerHTML .= new SubmitElement(self::KEY_SUBMIT, gettext("BUTTON_LOGIN_SUBMIT"));
        $this->setInnerHTML($innerHTML);
    }

}
