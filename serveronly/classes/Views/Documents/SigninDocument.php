<?php

namespace WalkSafe\Views\Documents;

use WalkSafe\Controls\SessionManager;
use WalkSafe\Controls\LoginManager;
use WalkSafe\Views\Documents\PublicDocument;
use WalkSafe\Views\Elements\SigninFormElement;
use WalkSafe\Views\Elements\TextElement;

class SigninDocument extends PublicDocument {

    public function __construct() {
        parent::__construct(gettext("TITLE_SIGNIN"));
    }

    protected function setupHTML() {
        if (!SessionManager::isLoggedIn()) {
            $this->addContent(new SigninFormElement('signin.php'));
        } else {
            $title = gettext("TITLE_ALREADY_LOGGEDIN");
            $message = gettext("MESSAGE_ALREADY_LOGGEDIN");
            $this->addContent(new TextElement($message, $title));
        }
    }

    protected function execute() {
        if (!SessionManager::isLoggedIn()) {
            if (!empty($this->getValue(SigninFormElement::KEY_SUBMIT))) {
                /**
                 * The submit button was set so we can check the
                 * username, password and email address to continue.
                 */
                $username = $this->getValue(SigninFormElement::KEY_USERNAME);
                $password = $this->getValue(SigninFormElement::KEY_PASSWORD);
                $email    = $this->getValue(SigninFormElement::KEY_EMAIL);
                if (empty($username) || empty($password) || empty($email)) {
                    /**
                     * At least one of the required information
                     * in missing so we can not continue.
                     */
                    $this->addContent(new TextElement(
                        gettext("MESSAGE_REGISTER_INFORMATION_MISSING"),
                        gettext("TITLE_MISSING_INFORMATION")
                    ));
                    return false;
                }
                $loginmanager = new LoginManager();
                if (!$loginmanager->isUsernameAvailable($username)) {
                    /**
                     * The requested username is already used by another user.
                     */
                    $this->addContent(new TextElement(
                        gettext("MESSAGE_USERNAME_ALREADY_TAKEN"),
                        gettext("TITLE_USERNAME_ALREADY_TAKEN")
                    ));
                    return false;
                }
                $verifyhash = $loginmanager->addAccountVerification($username, $password, $email);
                if (!$verifyhash) {
                    $this->addContent(new TextElement(
                        gettext("MESSAGE_REGISTER_PENDING_VERIFICATION"),
                        gettext("TITLE_REGISTER_PENDING_VERIFICATION")
                    ));
                    return false;
                }
                $emailsender = new VerifyMail($email, $username, $verifyhash);
                if ($emailsender->send()) {
                    $this->addContent(new TextElement(
                        gettext("MESSAGE_REGISTER_VERIFICATION_MAIL_SUCCESS"),
                        gettext("TITLE_REGISTER_VERIFICATION_MAIL_SUCCESS")
                    ));
                    return true;
                } else {
                    $this->addContent(new TextElement(
                        gettext("MESSAGE_REGISTER_VERIFICATION_MAIL_FAILURE"),
                        gettext("TITLE_REGISTER_VERIFICATION_MAIL_FAILURE")
                    ));
                    return false;
                }
            }
        }
    }

}
