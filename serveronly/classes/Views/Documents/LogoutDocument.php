<?php

class LogoutDocument extends MemberDocument {

    public function __construct() {
        parent::__construct(gettext("TITLE_LOGOUT"));
    }

    protected function execute() {
        if (SessionManager::logout()) {
            /**
             * The user session was removed successfully
             * so we can inform the user about it.
             */
            $this->addContent(new TextElement(
                gettext("MESSAGE_LOGOUT_SUCCESS"),
                gettext("SUBTITLE_LOGOUT_SUCCESS")
            ));
        } else {
            /**
             * Something strange happend so the user could not be logged out.
             * Inform the user about this issue so he / she known that the
             * session is still active.
             */
            $this->addContent(new TextElement(
                gettext("MESSAGE_LOGOUT_FAILURE"),
                gettext("SUBTITLE_LOGOUT_FAILURE")
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
