<?php

class VerifyDocument extends PublicDocument {

    protected $verifyid;

    public function __construct() {
        parent::__construct(gettext("Verify access"));
    }

    protected function readInputData() {
        parent::readInputData();
        $this->verifyid = $this->getValue('hash');
    }

    /**
     * This site only shows what it is made for independently of a hash key.
     */
    protected function setupHTML() {
        if (empty($this->verifyid)) {
            $formcontent  = new TextElement(gettext("This site will provide the ability to verify new user accounts."));
            $formcontent .= new TextInputElement('hash', '', gettext("Verification hash"));
            $formcontent .= new SubmitElement('verify', gettext("Verify account"));
            $this->addContent(new FormElement('verify.php', $formcontent));
        }
    }

    /**
     * Verifies the given verify hash
     * @return boolean True on success or false
     */
    private function verify() {
        $loginmanager = new LoginManager();
        $is_pending = $loginmanager->isVerifyHashPending($this->verifyid);
        if ($is_pending) {
            return $loginmanager->transformPendingVerificationToUser($this->verifyid);
        }
        return false;
    }

    protected function execute() {
        if (!empty($this->verifyid)) {
            /**
             * Hash was available so we can use/check it.
             */
            if ($this->verify()) {
                /**
                 * The verification was correct and replaced by the new user
                 * with success. So we can inform the user to login using the
                 * credentials of the new account.
                 */
                $this->addContent(new TextElement(
                    gettext("You have verified your new account successfully. Now you can log in."),
                    gettext("Success")
                ));
                return true;
            } else {
                /**
                 * An error occured during the verification. This may be
                 * because the hash is invalid or because a database error
                 * caused a break during the generation of the new user.
                 * Since we use transactions we are safe.
                 */
                $this->addContent(new TextElement(
                    gettext("Could not verify your new user. Maybe the given hash is not correct or a temporary database error caused this."),
                    gettext("Failure")
                ));
                return false;
            }
        }
    }

}
