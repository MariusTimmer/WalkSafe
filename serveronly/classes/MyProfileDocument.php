<?php

class MyProfileDocument extends MemberDocument {

    public function __construct() {
        parent::__construct(gettext("My profile"));
    }

    protected function setupHTML() {
        $profileobject = new Profile();
        $profile = $profileobject->getProfileByUserID(SessionManager::getCurrentUserID());
        $showlist = array(
            gettext("Name") => htmlentities($profile['firstname'] .' '. $profile['lastname']),
            gettext("Gender") => (intval($profile['ismale']) === 1) ? gettext("Male") : gettext("Female"),
            gettext("Day of birth") => date('d.m.Y', strtotime($profile['dayofbirth']))
        );
        $this->addContent(new KeyValueListElement(
            $showlist,
            gettext("General information"),
            gettext("This are the general information about you. Keep in mind that you can not change this static values often.")
        ));
    }

}
