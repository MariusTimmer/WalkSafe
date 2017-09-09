<?php

/**
 * This class represents the document to show and edit the users own profile.
 * @date 2017-08-27
 */
class MyProfileDocument extends MemberDocument {

    public function __construct() {
        parent::__construct(gettext("TITLE_MY_PROFILE"));
    }

    /**
     * Setup the HTML code to show the user profile data and provide the
     * ability to modify the profile data.
     */
    protected function setupHTML() {
        $profileobject = new Profile();
        $profile = $profileobject->getProfileByUserID(SessionManager::getCurrentUserID());
        $showlist = array(
            gettext("LABEL_NAME") => htmlentities($profile['firstname'] .' '. $profile['lastname']),
            gettext("LABEL_GENDER") => (intval($profile['ismale']) === 1) ? gettext("GENDER_MALE") : gettext("GENDER_FEMALE"),
            gettext("LABEL_DOB") => date(gettext('FORMAT_DOB'), strtotime($profile['dayofbirth']))
        );
        $this->addContent(new KeyValueListElement(
            $showlist,
            gettext("SUBTITLE_MY_PROFILE"),
            gettext("MY_PROFILE_GENERAL_INFORMATION")
        ));
        $this->addContent($this->buildInterestList($profileobject->getInterests(SessionManager::getCurrentUserID())));
    }

    /**
     * Builds the HTML element to show the users hobbies and interests.
     * @param array $list List of hobbies
     * @return string HTML-Code
     */
    private function buildInterestList($list) {
        $html_list = '<ul>';
        foreach ($list AS $index => $interest) {
            $html_list .= '<li id="interestid_'. htmlentities($interest['interestid']) .'">'. gettext($interest['label']) .'</li>';
        }
        $html_list .= '</ul>';
        return new TextElement($html_list, gettext("USER_INTERESTS"));
    }

}
