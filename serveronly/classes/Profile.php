<?php

class Profile extends DAO {

    public function getProfileByID($profileid) {
        return $this->_getProfile('profileid', $profileid);
    }

    public function getProfileByUserID($userid) {
        return $this->_getProfile('userid', $userid);
    }

    private function _getProfile($columnname, $value) {
        $query = 'SELECT profileid, userid, firstname, lastname, ismale, dayofbirth, infotext, created FROM profiles WHERE '. $columnname .' = :crit';
        return $this->pdo->executeQuery($query, array(
            'crit' => $value
        ), false);
    }

    /**
     * Updates a given profile.
     * @param array Profile data
     * @return boolean True on success or false
     */
    public function update($profile) {
        $query = 'UPDATE profiles SET firstname = :firstname, lastname = :lastname, ismale = :ismale, dayofbirth = :dayofbirth WHERE userid = :userid';
        return $this->pdo->executeQuery($query, $profile);
    }

    /**
     * Fetches the list of interests for a given profileid.
     * @param integer $profileid ProfileID of the requested user profile
     * @return array List of interests
     */
    public function getInterests($profileid) {
        $query = 'SELECT interests.interestid, interests.label, profile_interests.created FROM interests LEFT JOIN profile_interests USING (interestid) WHERE profile_interests.profileid = :profileid';
        return $this->pdo->executeQuery($query, array(
            'profileid' => $profileid
        ));
    }

}
