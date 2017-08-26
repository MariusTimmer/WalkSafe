<?php

class SigninDocument extends PublicDocument {

    public function __construct() {
        parent::__construct(gettext("Signin"));
    }

    protected function setupHTML() {
        if (!SessionManager::isLoggedIn()) {
            $this->addContent(new SigninFormElement('signin.php'));
        } else {
            $title = gettext("Already logged in");
            $message = gettext("You can not create a new account because you are already logged in. You need to log out before you can do this.");
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
                        gettext("You need to give us your username, password and email address. If one of these information is missing we can not continue."),
                        gettext("Failure")
                    ));
                    return false;
                }
                $loginmanager = new LoginManager();
                if (!$loginmanager->isUsernameAvailable($username)) {
                    /**
                     * The requested username is already used by another user.
                     */
                    $this->addContent(new TextElement(
                        gettext("The requested username is already used by another user."),
                        gettext("Failure")
                    ));
                    return false;
                }
                $verifyhash = $loginmanager->addAccountVerification($username, $password, $email);
                if (!$verifyhash) {
                    $this->addContent(new TextElement(
                        gettext("Could not create an verification hash. Maybe you already have created an request."),
                        gettext("Failure")
                    ));
                    return false;
                }
                $emailsender = new VerifyMail($email, $username, $verifyhash);
                if ($emailsender->send()) {
                    $this->addContent(new TextElement(
                        gettext("An E-Mail containing your personal verification hash was sent to you. Please click on the link in the mail to continue."),
                        gettext("Success")
                    ));
                    return true;
                } else {
                    $this->addContent(new TextElement(
                        gettext("The E-Mail containing your personal verification hash could not be sent. Please try again or contact the administrator."),
                        gettext("Failure")
                    ));
                    return false;
                }
            }
        }
    }

}
