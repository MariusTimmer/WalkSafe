<?php

namespace WalkSafe\Views\Documents;

use WalkSafe\Controls\UserManager;
use WalkSafe\Controls\SessionManager;

class MemberDocument extends Document {

    protected $usermanager;

    public function __construct($subtitle) {
        parent::__construct($subtitle);
    }

    protected function readInputData() {
        $this->usermanager = new UserManager();
    }

    /**
     * Returns the current user.
     * @return object User object
     */
    protected function getCurrentUser() {
        return $this->usermanager->getUserById(SessionManager::getCurrentUserID());
    }

    protected function allowedView() {
        return (SessionManager::isLoggedIn());
    }

}
