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
        $innerHTML  = '<p>In order to use this application you have to enter your user credentials here:</p>';
        $innerHTML .= '<fieldset><legend>'. gettext("User credentials") .'</legend>';
        $innerHTML .= '<label for="'. self::KEY_USERNAME .'">'. gettext("Username") .':</label>'. new TextInputElement(self::KEY_USERNAME, '', gettext("John Doe")) .'<br />';
        $innerHTML .= '<label for="'. self::KEY_PASSWORD .'">'. gettext("Password") .':</label>'. new PasswordInputElement(self::KEY_PASSWORD, '', gettext("Password"));
        $innerHTML .= '</fieldset>';
        $innerHTML .= new SubmitElement(self::KEY_SUBMIT, gettext("Login"));
        $this->setInnerHTML($innerHTML);
    }

}
