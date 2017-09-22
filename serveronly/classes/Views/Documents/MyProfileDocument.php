<?php

/**
 * This class represents the document to show and edit the users own profile.
 * @date 2017-08-27
 */
class MyProfileDocument extends MemberDocument {

    const MODE_VIEW = 0;
    const MODE_CHANGE = 1;
    const MODE_SAVE = 2;
    const MODE_DEFAULT = self::MODE_VIEW;
    const POST_KEY_MODE = 'mode';
    const POST_KEY_FIRSTNAME = 'firstname';
    const POST_KEY_LASTNAME = 'lastname';
    const POST_KEY_GENDER = 'gender';
    const POST_KEY_DOB = 'dob';
    const POST_KEY_SUBMIT = 'submit';
    protected $mode;
    protected $profileobject;

    public function __construct() {
        parent::__construct(gettext("TITLE_MY_PROFILE"));
    }

    protected function readInputData() {
        $this->mode = $this->getValue(self::POST_KEY_MODE);
        if (empty($this->mode)) {
            $this->mode = self::MODE_DEFAULT;
        }
        $this->profileobject = new Profile();
    }

    protected function execute() {
        if (($this->mode == self::MODE_SAVE) &&
            (!empty($this->getValue(self::POST_KEY_SUBMIT)))) {
            $firstname = $this->getValue(self::POST_KEY_FIRSTNAME);
            $lastname = $this->getValue(self::POST_KEY_LASTNAME);
            $dob = $this->getValue(self::POST_KEY_DOB);
            switch ($this->getValue(self::POST_KEY_GENDER)) {
                case GenderSelectionElement::GENDER_MALE:
                    $gender = 1;
                    break;
                case GenderSelectionElement::GENDER_FEMALE:
                    $gender = 0;
                    break;
                default:
                    $gender = -1;
            }
            if (empty($firstname) || empty($lastname)) {
                /**
                 * We want to have the full name of our users so we do not
                 * allow them to remove the first or last name. Keep in mind
                 * that we do not know weather the given name is real or fake.
                 */
                $this->addContent(new TextElement(
                    gettext("MESSAGE_FULLNAME_REQUIRED"),
                    gettext("TITLE_MISSING_INFORMATION")
                ));
                return false;
            }
            $profiledata = array(
                'userid' => SessionManager::getCurrentUserID(),
                'firstname' => $firstname,
                'lastname' => $lastname,
                'ismale' => $gender,
                'dayofbirth' => $dob
            );
            $updatestatus = $this->profileobject->update($profiledata);
            if ($updatestatus) {
                $this->addContent(new TextElement(
                    gettext("MESSAGE_PROFILEUPDATE_SUCCESS"),
                    gettext("TITLE_PROFILEUPDATE_SUCCESS")
                ));
                return true;
            } else {
                $this->addContent(new TextElement(
                    gettext("MESSAGE_PROFILEUPDATE_FAILURE"),
                    gettext("TITLE_PROFILEUPDATE_FAILURE")
                ));
                return false;
            }
        }
    }

    /**
     * Setup the HTML code to show the user profile data and provide the
     * ability to modify the profile data.
     */
    protected function setupHTML() {
        $profile = $this->profileobject->getProfileByUserID(SessionManager::getCurrentUserID());
        switch ($this->mode) {
            case self::MODE_CHANGE:
                $this->buildProfileChangeForm($profile);
                break;
            default:
                $this->buildProfileView($profile);
        }
    }

    /**
     * Provides the formular to change the profile data.
     * @param Profile $profile Profile data
     */
    protected function buildProfileChangeForm($profile) {
        $form_content = new TextElement(
            gettext("MESSAGE_MYPROFILE_CHANGE")
        );
        $attributelist = array(
            array(
                'label' => gettext("LABEL_FIRSTNAME"),
                'name' => self::POST_KEY_FIRSTNAME,
                'value' => $profile['firstname']
            ),
            array(
                'label' => gettext("LABEL_LASTNAME"),
                'name' => self::POST_KEY_LASTNAME,
                'value' => $profile['lastname']
            ),
            array(
                'label' => gettext("LABEL_DOB"),
                'name' => self::POST_KEY_DOB,
                'value' => $profile['dayofbirth']
            )
        );
        foreach ($attributelist AS $index => $attribute) {
            $element = new LabeledTextInputElement(
                $attribute['label'],
                $attribute['name'],
                $attribute['value']
            );
            $form_content .= $element;
        }
        $selection_gender = GenderSelectionElement::GENDER_FEMALE;
        if ($profile['ismale']) {
            $selection_gender = GenderSelectionElement::GENDER_MALE;
        }
        $form_content .= new GenderSelectionElement(
            self::POST_KEY_GENDER,
            $selection_gender
        );
        $form_content .= new SubmitElement(self::POST_KEY_SUBMIT, gettext("APPLY_CHANGES"));
        $this->addContent(new FormElement(
            '?'. self::POST_KEY_MODE .'='. self::MODE_SAVE,
            $form_content
        ));
    }

    /**
     * Provides the normal view of the profile data.
     * @param Profile $profile Profile data
     */
    protected function buildProfileView($profile) {
        $this->addContent(
            $this->addContent(new TextElement(
                new LabelElement(gettext("LABEL_MYPROFILE_GOTO_CHANGE_FORM"), 'modify_link', true) . '<a href="?'. self::POST_KEY_MODE .'='. self::MODE_CHANGE .'" id="modify_link">'. strval(new IconElement('pencil', '', gettext("ALTERNATIVE_PENCIL"))) .'</a>'
            ))
        );
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
        $this->addContent($this->buildInterestList($this->profileobject->getInterests(SessionManager::getCurrentUserID())));
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
