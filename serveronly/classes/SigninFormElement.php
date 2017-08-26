<?php

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
        $innerHTML  = '<p>We are glad that you want to register a new account. Fill in the following form and we will send you an email with an activation link.</p>';
        $innerHTML .= '<label for="'. self::KEY_USERNAME .'">'. gettext("Username") .':</label>'. new TextInputElement(self::KEY_USERNAME, '', gettext("John Doe")) .'<br />';
        $innerHTML .= '<label for="'. self::KEY_EMAIL .'">'. gettext("E-Mail") .':</label>'. new TextInputElement(self::KEY_EMAIL, '', gettext("John.Doe@internet.com")) .'<br />';
        $innerHTML .= '<label for="'. self::KEY_PASSWORD .'">'. gettext("Password") .':</label>'. new PasswordInputElement(self::KEY_PASSWORD, '', gettext("Password"));
        $innerHTML .= new SubmitElement(self::KEY_SUBMIT, gettext("SignIn"));
        $this->setInnerHTML($innerHTML);
    }

}
