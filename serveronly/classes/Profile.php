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

}
