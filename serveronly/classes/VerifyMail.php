<?php

namespace WalkSafe;

use WalkSafe\Configuration;

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
            sprintf(gettext("MAIL_VERIFY_INTRODUCTION"), $this->username),
            '',
            gettext("MAIL_VERIFY_BODY"),
            sprintf(
                'https://%s/escort/verify.php?hash=%s',
                Configuration::get('FQDN', 'GENERAL'),
                $this->hash
            ),
            '',
            gettext("MAIL_VERIFY_GREETINGS")
        ));
    }

    protected function getSubject() {
        return sprintf(
            gettext("MAIL_VERIFY_SUBJECT"),
            $this->username
        );
    }

}
