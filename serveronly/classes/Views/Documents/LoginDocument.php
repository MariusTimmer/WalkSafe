<?php

class LoginDocument extends PublicDocument {

    public function __construct() {
        parent::__construct(gettext("TITLE_LOGIN"));
    }

    protected function setupHTML() {
        if (!SessionManager::isLoggedIn()) {
            /**
             * The user is not logged in so we offer him/her the login formular.
             */
            $this->addContent(new LoginFormElement('login.php'));
        }
    }

    protected function execute() {
        if (!SessionManager::isLoggedIn()) {
            /**
             * The only task this document can execute is to log a user in. If
             * the user already is logged in we do not need to take any action.
             */
            if (!empty($this->getValue(LoginFormElement::KEY_SUBMIT))) {
                /**
                 * The submit button was set so we can check
                 * the username and password and continue.
                 */
                $username = $this->getValue(LoginFormElement::KEY_USERNAME);
                $password = $this->getValue(LoginFormElement::KEY_PASSWORD);
                $success = SessionManager::login($username, $password);
                if ($success) {
                    $this->addContent(new TextElement(
                        gettext("MESSAGE_LOGIN_WELCOME"),
                        gettext("SUBTITLE_LOGIN_WELCOME")
                    ));
                } else {
                    $this->addContent(new TextElement(
                        gettext("MESSAGE_LOGIN_FAILURE"),
                        gettext("SUBTITLE_LOGIN_FAILURE")
                    ));
                }
            }
        }
    }

    public function __toString() {
        if (!SessionManager::isLoggedIn()) {
            return parent::__toString();
        } else {
            return ((string) new HomeDocument());
        }
    }

}
