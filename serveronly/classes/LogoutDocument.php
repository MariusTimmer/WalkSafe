<?php

class LogoutDocument extends MemberDocument {

    public function __construct() {
        parent::__construct(gettext("Logout"));
    }

    protected function execute() {
        if (SessionManager::logout()) {
            /**
             * The user session was removed successfully
             * so we can inform the user about it.
             */
            $this->addContent(new TextElement(
                gettext("You were logged out successfully!"),
                gettext("Logged out")
            ));
        } else {
            /**
             * Something strange happend so the user could not be logged out.
             * Inform the user about this issue so he / she known that the
             * session is still active.
             */
            $this->addContent(new TextElement(
                gettext("Some strange error occured so you are still logged in. Please try it again or contact a system administrator. If you gonna leave the computer and another person will use it, make sure you close the session by closing your browser."),
                gettext("You are still logged in")
            ));
        }
    }

    /**
     * Since the logout proccess will be executed before the output is
     * generated and so a permission denied message would occure we generally
     * allow everyone to see this site since it does not do anything special.
     * This means that logged out or anonymous people will be able to see this
     * document but who cares about the logout page.
     */
    protected function allowedView() {
        return true;
    }

}
