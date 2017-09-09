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
