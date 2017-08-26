<?php

class VerifyMail extends EMail {

    protected $email;
    protected $username;
    protected $hash;

    public function __construct($email, $username, $hash) {
        parent::__construct($email);
        $this->username = $username;
        $this->hash = $hash;
    }

    protected function getContent() {
        return implode("\r\n", array(
            sprintf(gettext("Dear %s,"), $this->username),
            '',
            gettext("we are glad that you want to create a new account and become a new member of this escort service. There is just one last step you have to do before you can log in to the application. Just click the link below containing your verification hash:"),
            sprintf(
                'https://%s/escort/verify.php?hash=%s',
                $this->serverconfiguration->getFQDN(),
                $this->hash
            ),
            '',
            gettext("Thank you and have a nice day!")
        ));
    }

    protected function getSubject() {
        return sprintf(
            gettext("Account verification for %s"),
            $this->username
        );
    }

}
