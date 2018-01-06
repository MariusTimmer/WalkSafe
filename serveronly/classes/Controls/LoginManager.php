<?php

namespace WalkSafe\Controls;

class LoginManager extends DAO {

    public function getUserIDByUsernameAndPassword($username, $password) {
        $result = $this->pdo->executeQuery('SELECT userid FROM users WHERE username = :username AND passwordhash = :passwordhash', array(
            'username' => $username,
            'passwordhash' => hash('sha512', $password)
        ), true);
        if (!$result || count($result) === 0) {
            return false;
        }
        return $result[0]['userid'];
    }

    public function isUsernameAvailable($username) {
        $query = 'SELECT COUNT(*) AS amount FROM users WHERE username = :username';
        $result = $this->pdo->executeQuery($query, array(
            'username' => $username
        ), false);
        return ($result && intval($result['amount']) === 0);
    }

    public function getVerifyHash($email) {
        $query = 'SELECT verifyid FROM verifications WHERE email = :email';
        $result = $this->pdo->executeQuery($query, array(
            'email' => $email
        ));
        if (!is_array($result) || count($result) === 0) {
            return false;
        }
        return $result[0]['verifyid'];
    }

    /**
     * Creates a new user and deleted the pending verification.
     * @param string $hash Verification Hash to use
     * @return boolean True on success or false
     */
    public function transformPendingVerificationToUser($hash) {
        $query_select = 'SELECT verifyid, username, passwordhash, email FROM verifications WHERE verifyid = :hash';
        $verification = $this->pdo->executeQuery($query_select, array(
            'hash' => $hash
        ), false);
        try {
            $this->pdo->getConnection()->beginTransaction();
            $query_insert = 'INSERT INTO users (username, email, passwordhash) VALUES (:username, :email, :passwordhash)';
            $insert = $this->pdo->executeQuery($query_insert, array(
                'username' => $verification['username'],
                'email' => strtolower($verification['email']),
                'passwordhash' => $verification['passwordhash']
            ));
            $query_delete = 'DELETE FROM verifications WHERE verifyid = :hash';
            $delete = $this->pdo->executeQuery($query_delete, array(
                'hash' => $hash
            ), false);
            $this->pdo->getConnection()->commit();
            return true;
        } catch (PDOException $ex) {
            trigger_error($ex->getMessage());
            $this->pdo->getConnection()->rollBack();
            return false;
        }
    }

    /**
     * Determinates weather the requested hash is pending or not.
     * @param string $hash Hash to check
     * @return boolean True if hash is pending or false
     */
    public function isVerifyHashPending($hash) {
        $query = 'SELECT COUNT(*) AS amount FROM verifications WHERE verifyid = :hash';
        $result = $this->pdo->executeQuery($query, array(
            'hash' => $hash
        ));
        if (!is_array($result) || count($result) === 0) {
            return false;
        }
        return (intval($result[0]['amount']) === 1);
    }

    public function addAccountVerification($username, $password, $email) {
        $verifyid = hash('sha512', $username . $password . $email . time(), false);
        $query = 'INSERT INTO verifications (verifyid, username, passwordhash, email) VALUES (:verifyid, :username, :passwordhash, :email)';
        $result = $this->pdo->executeQuery($query, array(
            'verifyid' => $verifyid,
            'username' => $username,
            'passwordhash' => hash('sha512', $password),
            'email' => strtolower($email)
        ), false);
        return $this->getVerifyHash($email);
    }

}
