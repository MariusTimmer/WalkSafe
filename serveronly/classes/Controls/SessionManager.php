<?php

session_start();

class SessionManager {

    const SESSION_KEY_USERID = 'userid';
    const SESSION_KEY_LOGINTIME = 'logintime';

    public static function getCurrentUserID() {
        return $_SESSION[self::SESSION_KEY_USERID];
    }

    /**
     * Determinates weather the user is logged in or not.
     * @return boolean True if the user is logged in or false
     */
    public static function isLoggedIn() {
        return ((isset($_SESSION[self::SESSION_KEY_USERID])) &&
                ($_SESSION[self::SESSION_KEY_USERID] > 0));
    }

    private static function checkCredentials($username, $password) {
        $loginmanager = new LoginManager();
        return $loginmanager->getUserIDByUsernameAndPassword($username, $password);
    }

    public static function login($username, $password) {
        $userid = self::checkCredentials($username, $password);
        if ($userid === false) {
            self::logout();
            return false;
        }
        $_SESSION[self::SESSION_KEY_USERID] = $userid;
        $_SESSION[self::SESSION_KEY_LOGINTIME] = time();
        return true;
    }

    /**
     * Logs out the current user removing all session variables.
     * @return boolean True on success or false
     */
    public static function logout() {
        session_unset();
        return (!isset($_SESSION[self::SESSION_KEY_USERID]));
    }

}
